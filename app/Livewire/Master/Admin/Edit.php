<?php

namespace App\Livewire\Master\Admin;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $username;
    public $email;
    public $kataSandi;
    public $konfirmasiKataSandi;
    public $avatar;
    public $role = 'admin';

    public $userId;
    public $avatarUrl;

    public function rules()
    {
        return [
            'username'      => ['required', 'string', 'min:2', 'max:255'],
            'role'          => ['required', 'string', 'min:2', 'max:255', Rule::in(config('const.roles'))],
            'email'         => ['nullable', 'string', 'min:2', 'unique:users,email,' . $this->userId],
            'kataSandi'     => ['nullable', 'string', 'same:konfirmasiKataSandi', Password::default()],
            'avatar'        => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function edit()
    {
        $this->validate();

        $user = User::whereId($this->userId)->first();

        try {
            DB::beginTransaction();

            $user->update([
                'username'          => $this->username,
                'role'              => $this->role,
                'email_verified_at' => now(),
            ]);

            if ($this->email) {
                $user->update([
                    'email' => strtolower($this->email),
                ]);
            }

            if ($this->kataSandi) {
                $user->update(['password' => bcrypt($this->kataSandi)]);
            }

            if ($this->avatar) {
                if ($user->avatar) {
                    File::delete(public_path('storage/' . $user->avatar));
                }

                $user->update(['avatar' => $this->avatar->store('avatars', 'public')]);
            }

            DB::commit();
        } catch (Exception $e) {
            logger()->error(
                '[pengguna] ' .
                    auth()->user()->username .
                    ' gagal menyunting pengguna',
                [$e->getMessage()]
            );

            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Gagal!',
                'detail' => "Gagal menyunting data pengguna.",
            ]);

            return redirect()->back();
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil!',
            'detail' => "Berhasil menyunting data pengguna.",
        ]);

        return redirect()->route('master.admin.index');
    }

    public function mount($id)
    {
        $user = User::findOrFail($id);

        $this->userId       = $user->id;
        $this->username     = $user->username;
        $this->email        = $user->email;
        $this->role         = $user->role;
        $this->avatarUrl    = $user->avatarUrl();
    }

    public function render()
    {
        return view('livewire.master.admin.edit');
    }
}
