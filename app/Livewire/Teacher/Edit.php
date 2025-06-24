<?php

namespace App\Livewire\Teacher;

use App\Models\Teacher;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $nama;
    public $nip;
    public $nuptk;
    public $jenisKelamin;
    public $alamat;
    public $kodePos;
    public $nomorPonsel;
    public $email;
    public $tempatLahir;
    public $tanggalLahir;
    public $agama;
    public $tanggalBergabung;
    public $kataSandi;
    public $konfirmasiKataSandi;
    public $avatar;
    public $role = 'teacher';

    // IDENTITY
    public $userId;
    public $teacherId;

    public function rules(){
        return [
            'nama'              => ['required', 'string', 'min:2', 'max:255'],
            'nip'               => ['nullable', 'string', 'min:2', 'max:255'],
            'nuptk'             => ['nullable', 'string', 'min:2', 'max:255'],
            'jenisKelamin'      => ['required', 'string', 'min:2', 'max:255'],
            'alamat'            => ['nullable', 'string'],
            'nomorPonsel'       => ['nullable', 'string', 'max:255'],
            'email'             => ['nullable', 'email', 'max:255', 'unique:users,email,' . $this->userId],
            'tempatLahir'       => ['nullable', 'string', 'max:255'],
            'tanggalLahir'      => ['nullable', 'date'],
            'agama'             => ['nullable', 'string', 'max:255', Rule::in(config('const.religions'))],
            'tanggalBergabung'  => ['nullable', 'date'],
            'kataSandi'         => ['nullable', 'string', 'same:konfirmasiKataSandi', Password::default()],
            'avatar'            => ['nullable', 'image', 'max:2048'],
            'kodePos'           => ['nullable', 'string', 'max:10'],
        ];
    }

    public function edit(){
        $this->validate();

        try{
            DB::beginTransaction();

            $user = User::findOrFail($this->userId);

            $user->update([
                'username'          => $this->nama,
                'email'             => strtolower($this->email),
                'password'          => bcrypt($this->kataSandi),
                'role'              => $this->role,
                'email_verified_at' => now(),
            ]);

            $teacher = Teacher::findOrFail($this->teacherId);

            $teacher->update([
                'user_id'           => $user->id,
                'name'              => $this->nama,
                'sex'               => $this->jenisKelamin,
                'nip'               => $this->nip,
                'nuptk'             => $this->nuptk,
                'phone'             => $this->nomorPonsel,
                'religion'          => $this->agama,
                'birth_date'        => $this->tanggalLahir,
                'place_of_birth'    => $this->tempatLahir,
                'address'           => $this->alamat,
                'postal_code'       => $this->kodePos,
                'date_joined'       => $this->tanggalBergabung,
            ]);

            if ($this->avatar) {
                if($teacher->photo) {
                    Storage::disk('public')->delete($teacher->photo);

                    $teacher->update([
                        'photo' => $this->avatar ? $this->avatar->store('student-photos', 'public') : null,
                    ]);

                    $user->update([
                        'avatar' => $teacher->photo,
                    ]);
                }
            }

            DB::commit();
        }catch(Exception $e){
            DB::rollBack();

            logger()->error(
                '[guru] ' .
                    auth()->user()->username .
                    ' gagal menyunting guru',
                [$e->getMessage()]
            );

            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Gagal!',
                'detail' => "Gagal menyunting data guru.",
            ]);

            return redirect()->back();
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil!',
            'detail' => "Berhasil menyunting data guru.",
        ]);

        return redirect()->route('teacher.index');
    }

    public function mount($id){
        $teacher = Teacher::findOrFail($id);
        $user = User::findOrFail($teacher->user_id);

        $this->userId = $user->id;
        $this->teacherId = $teacher->id;

        $this->nama = $teacher->name;
        $this->nip = $teacher->nip;
        $this->nuptk = $teacher->nuptk;
        $this->jenisKelamin = $teacher->sex;
        $this->alamat = $teacher->address;
        $this->kodePos = $teacher->postal_code;
        $this->nomorPonsel = $teacher->phone;
        $this->email = $user->email;
        $this->tempatLahir = $teacher->place_of_birth;
        $this->tanggalLahir = $teacher->birth_date;
        $this->agama = $teacher->religion;
        $this->tanggalBergabung = $teacher->date_joined;
    }

    public function render()
    {
        return view('livewire.teacher.edit');
    }
}
