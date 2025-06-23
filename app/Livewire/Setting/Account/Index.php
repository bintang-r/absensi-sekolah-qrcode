<?php

namespace App\Livewire\Setting\Account;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $userId;
    public $username;
    public $surel;
    public $nomorPonsel;
    public $kataSandi;
    public $konfirmasiKataSandi;
    public $statusAkun;
    public $avatar;
    public $avatarUrl;

    public function rules()
    {
        return [
            'username' => [
                'required',
                'unique:users,username,' . $this->userId,
                'min:3',
                'max:12',
                'regex:/\w*$/',
            ],
            'surel' => [
                'required',
                'email',
                'unique:users,email,' . $this->userId,
            ],
            'kataSandi' => ['nullable', 'min:6', 'same:konfirmasiKataSandi'],
            'avatar' => ['nullable', 'file', 'image', 'max:1024'],
        ];
    }

    public function updatedUsername()
    {
        $this->validateOnly('username');
    }

    public function updatedSurel()
    {
        $this->validateOnly('surel');
    }

    public function updatedAvatar()
    {
        $this->validateOnly('avatar');
    }

    public function edit()
    {
        $this->validate();

        $user = User::findOrFail($this->userId);

        try {
            $user->update([
                'username' => $this->username,
                'email' => $this->surel,
            ]);

            if ($this->avatar) {
                if ($user->avatar) {
                    File::delete(public_path('storage/' . $this->avatar));
                }

                $user->update([
                    'avatar' => $this->avatar->store('avatar', 'public'),
                ]);
            }

            if ($this->kataSandi) {
                $user->update([
                    'password' => bcrypt($this->kataSandi),
                ]);
            }
        } catch (Exception $e) {
            logger()->error(
                '[setting] ' .
                    auth()->user()->username .
                    ' gagal menyunting akun',
                [$e->getMessage()]
            );

            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Gagal!',
                'detail' => 'Akun gagal disunting.',
            ]);

            return redirect()->back();
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil!',
            'detail' => 'Akun berhasil disunting.',
        ]);

        return redirect()->back();
    }

    public function mount()
    {
        $user = User::findOrFail(auth()->user()->id);

        $this->userId = $user->id;
        $this->username = $user->username;
        $this->surel = $user->email;

        $this->avatarUrl = $user->avatarUrl();
    }

    public function render()
    {
        return view('livewire.setting.account.index');
    }
}
