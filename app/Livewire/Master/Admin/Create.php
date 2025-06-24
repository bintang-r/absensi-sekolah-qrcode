<?php

namespace App\Livewire\Master\Admin;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $username;
    public $email;
    public $kataSandi;
    public $avatar;
    public $role = 'admin';
    public $konfirmasiKataSandi;

    public function validateData()
    {
        $this->validate([
            'username'      => ['required', 'string', 'min:2', 'max:255'],
            'role'          => ['required', 'string', 'min:2', 'max:255', Rule::in(config('const.roles'))],
            'email'         => ['required', 'string', 'min:2', 'unique:users,email'],
            'kataSandi'     => ['required', 'string', 'same:konfirmasiKataSandi', Password::default()],
            'avatar'        => ['nullable', 'image', 'max:2048'],
        ]);
    }

    public function save()
    {
        $this->validateData();

        try {
            DB::beginTransaction();

            $user = User::create([
                'username'          => $this->username,
                'email'             => strtolower($this->email),
                'password'          => bcrypt($this->kataSandi),
                'role'              => $this->role,
                'email_verified_at' => now(),
            ]);

            if ($this->avatar) {
                $user->update([
                    'avatar' => $this->avatar->store('avatars', 'public'),
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            logger()->error(
                '[pengguna] ' .
                    auth()->user()->username .
                    ' gagal menambahkan pengguna',
                [$e->getMessage()]
            );

            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Gagal!',
                'detail' => "Gagal menambahkan data pengguna.",
            ]);

            return redirect()->back();
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil!',
            'detail' => "Berhasil menambahkan data pengguna.",
        ]);

        return redirect()->route('master.admin.index');
    }

    public function render()
    {
        return view('livewire.master.admin.create');
    }
}
