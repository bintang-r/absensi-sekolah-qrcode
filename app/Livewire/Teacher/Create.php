<?php

namespace App\Livewire\Teacher;

use App\Models\SubjectStudy;
use App\Models\Teacher;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
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

    public function rules(){
        return [
            'nama'              => ['required', 'string', 'min:2', 'max:255'],
            'nip'               => ['nullable', 'string', 'min:2', 'max:255'],
            'nuptk'             => ['nullable', 'string', 'min:2', 'max:255'],
            'jenisKelamin'      => ['required', 'string', 'min:2', 'max:255'],
            'alamat'            => ['nullable', 'string'],
            'nomorPonsel'       => ['nullable', 'string', 'max:255'],
            'email'             => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'tempatLahir'       => ['nullable', 'string', 'max:255'],
            'tanggalLahir'      => ['nullable', 'date'],
            'agama'             => ['nullable', 'string', 'max:255', Rule::in(config('const.religions'))],
            'tanggalBergabung'  => ['nullable', 'date'],
            'kataSandi'         => ['required', 'string', 'same:konfirmasiKataSandi', Password::default()],
            'avatar'            => ['nullable', 'image', 'max:2048'],
            'kodePos'           => ['nullable', 'string', 'max:10'],
        ];
    }

    public function save(){
        $this->validate();

        try{
            DB::beginTransaction();

            $user = User::create([
                'username'          => $this->nama,
                'email'             => strtolower($this->email),
                'password'          => bcrypt($this->kataSandi),
                'role'              => $this->role,
                'email_verified_at' => now(),
            ]);

            $teacher = Teacher::create([
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
                'photo'             => $this->avatar ? $this->avatar->store('student-photos', 'public') : null,
            ]);

            if($teacher->photo){
                $user->update([
                    'avatar' => $teacher->photo,
                ]);
            }

            DB::commit();
        }catch(Exception $e){
            DB::rollBack();

            logger()->error(
                '[guru] ' .
                    auth()->user()->username .
                    ' gagal menambahkan guru',
                [$e->getMessage()]
            );

            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Gagal!',
                'detail' => "Gagal menambahkan data guru.",
            ]);

            return redirect()->back();
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil!',
            'detail' => "Berhasil menambahkan data guru.",
        ]);

        return redirect()->route('teacher.index');
    }

    public function render()
    {
        return view('livewire.teacher.create');
    }
}
