<?php

namespace App\Livewire\Master\ClassSchedule;

use App\Models\ClassRoom;
use App\Models\ClassSchedule;
use App\Models\SubjectStudy;
use App\Models\Teacher;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Edit extends Component
{
    public $guru;
    public $kelas;
    public $mataPelajaran;
    public $hari;
    public $waktuMasuk;
    public $waktuKeluar;
    public $keterangan;

    // IDENTITY
    public $classScheduleId;

    public function rules(){
        return [
            'guru' => ['required'],
            'kelas' => ['required'],
            'mataPelajaran' => ['required'],

            'hari' => ['required','string','min:2','max:255',Rule::in(config('const.name_days'))],
            'waktuMasuk' => ['required','min:2','max:255'],
            'waktuKeluar' => ['required','string','min:2','max:255'],
            'keterangan' => ['nullable','string'],
        ];
    }

    public function edit(){
        $this->validate();

        try{
            DB::beginTransaction();

            $classSchedule = ClassSchedule::findOrFail($this->classScheduleId);

            $classSchedule->update([
                'class_room_id' => $this->kelas,
                'teacher_id' => $this->guru,
                'subject_study_id' => $this->mataPelajaran,
                'day_name' => $this->hari,
                'start_time' => $this->waktuMasuk,
                'end_time' => $this->waktuKeluar,
                'description' => $this->keterangan,
            ]);

            DB::commit();
        }catch(Exception $e){
            DB::rollBack();

            logger()->error(
                '[class schedule] ' .
                    auth()->user()->username .
                    ' gagal menyunting jadwal kelas',
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

        return redirect()->route('master.class-schedule.index');
    }

    #[Computed()]
    public function teachers(){
        return Teacher::all(['id','name','nip']);
    }

    #[Computed()]
    public function class_rooms(){
        return ClassRoom::all(['id','name_class']);
    }

    #[Computed()]
    public function subject_studies(){
        return SubjectStudy::all(['id','name_subject']);
    }

    public function mount($id){
        $classSchedule = ClassSchedule::findOrFail($id);

        $this->classScheduleId = $classSchedule->id;
        $this->guru = $classSchedule->teacher_id;
        $this->kelas = $classSchedule->class_room_id;
        $this->mataPelajaran = $classSchedule->subject_study_id;
        $this->hari = $classSchedule->day_name;
        $this->waktuMasuk = $classSchedule->start_time;
        $this->waktuKeluar = $classSchedule->end_time;
        $this->keterangan = $classSchedule->description;
    }

    public function render()
    {
        return view('livewire.master.class-schedule.edit');
    }
}
