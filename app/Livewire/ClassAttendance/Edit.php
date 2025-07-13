<?php

namespace App\Livewire\ClassAttendance;

use App\Models\ClassAttendance;
use App\Models\ClassSchedule;
use App\Models\Student;
use App\Models\StudentAttendance;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $classScheduleId;
    public $classRoomId;
    public $classAttendanceId;

    public $namaMateri;
    public $buktiPresensi;
    public $penjelasanMateri;
    public $presensiSiswa = [];

    public function rules()
    {
        return [
            'presensiSiswa.*.nama' => ['required'],
            'presensiSiswa.*.nis' => ['required'],
            'presensiSiswa.*.status_kehadiran' => ['required'],
            'namaMateri' => ['required','min:2','max:255'],
            'penjelasanMateri' => ['nullable','string','min:2','max:255'],
            'buktiPresensi' => ['nullable','image'],
        ];
    }

    public function edit()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $classAttendance = ClassAttendance::findOrFail($this->classAttendanceId);

            $classAttendance->update([
                'class_room_id' => $this->classRoomId,
                'class_schedule_id' => $this->classScheduleId,
                'explanation_material' => $this->penjelasanMateri,
                'name_material' => $this->namaMateri,
            ]);

            if ($this->buktiPresensi) {
                if ($classAttendance->picture_evidence) {
                    File::delete(public_path('storage/' . $classAttendance->picture_evidence));
                }

                $classAttendance->update([
                    'picture_evidence' => $this->buktiPresensi->store('bukti-presensi', 'public'),
                ]);
            }

            foreach ($this->presensiSiswa as $studentId => $presensi) {
                StudentAttendance::updateOrCreate(
                    [
                        'class_attendance_id' => $classAttendance->id,
                        'student_id' => $studentId,
                    ],
                    [
                        'status_attendance' => $presensi['status_kehadiran'],
                    ]
                );
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            logger()->error(
                '[class attendance] ' .
                    auth()->user()->username .
                    ' gagal menyunting presensi pertemuan',
                [$e->getMessage()]
            );


            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Gagal!',
                'detail' => "Gagal menyunting data presensi pertemuan.",
            ]);

            return redirect()->back();
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil!',
            'detail' => "Berhasil menyunting data presensi pertemuan.",
        ]);

        return redirect()->route('class-attendance.detail', $this->classScheduleId);
    }

    public function mount($scheduleId, $classAttendanceId)
    {
        $classSchedule = ClassSchedule::with('class_room')->findOrFail($scheduleId);
        $this->classScheduleId = $classSchedule->id;
        $this->classRoomId = $classSchedule->class_room->id;

        $classAttendance = ClassAttendance::with('student_attendances.student')->findOrFail($classAttendanceId);
        $this->classAttendanceId = $classAttendance->id;

        $this->namaMateri = $classAttendance->name_material;
        $this->penjelasanMateri = $classAttendance->explanation_material;

        if ($classAttendance->student_attendances->count() > 0) {
            foreach ($classAttendance->student_attendances as $attendance) {
                $student = $attendance->student;
                $this->presensiSiswa[$student->id] = [
                    'nama' => $student->full_name,
                    'nis' => $student->nis,
                    'status_kehadiran' => $attendance->status_attendance,
                ];
            }
        } else {
            $students = Student::where('class_room_id', $this->classRoomId)
                ->get(['id', 'full_name', 'nis']);

            foreach ($students as $student) {
                $this->presensiSiswa[$student->id] = [
                    'nama' => $student->full_name,
                    'nis' => $student->nis,
                    'status_kehadiran' => 'hadir',
                ];
            }
        }
    }

    public function render()
    {
        return view('livewire.class-attendance.edit');
    }
}
