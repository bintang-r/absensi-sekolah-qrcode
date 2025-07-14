<?php

namespace App\Livewire\Home;

use App\Helpers\HomeChart;
use App\Models\ClassSchedule;
use App\Models\StudentAttendance;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class TeacherHome extends Component
{
    public $totalSchedule = 0;
    public $totalHadir = 0;
    public $totalAlpa = 0;
    public $totalIzin = 0;
    public $totalSakit = 0;

    public $attendanceHadir;
    public $attendanceAlpa;
    public $attendanceIzin;
    public $attendanceSakit;

    public $teacherId;
    public $period = 'daily';
    public $teacherSchedule;

    public function updatedPeriod(){
        $this->getDataCount();
        $this->updateDataChart();
    }

    public function updatedTeacherSchedule(){
        $this->getDataCount();
        $this->updateDataChart();
    }

    #[Computed()]
    public function class_schedules(){
        return ClassSchedule::where('teacher_id', $this->teacherId)->get();
    }

    public function getDataChart()
    {
        $statuses = ['hadir', 'alpa', 'izin', 'sakit'];

        foreach ($statuses as $status) {
            $property = 'attendance' . ucfirst($status);

            $query = StudentAttendance::query()
                ->where('status_attendance', $status)
                ->whereHas('class_attendance.class_schedule', function ($q) {
                    $q->where('teacher_id', $this->teacherId);
                });

            if ($this->teacherSchedule) {
                $query->whereHas('class_attendance.class_schedule', function ($q) {
                    $q->where('id', $this->teacherSchedule);
                });
            }

            $this->{$property} = HomeChart::CHART_DATA($query, $this->period);
        }
    }


    public function getDataCount(){
        $this->totalSchedule = ClassSchedule::where('teacher_id', $this->teacherId)->count();

        foreach (config('const.attendance_status') as $status) {
            $property = 'total' . ucfirst($status);

            $query = StudentAttendance::query()
                ->where('status_attendance', $status)
                ->whereHas('class_attendance.class_schedule', function ($q) {
                    $q->where('teacher_id', $this->teacherId);
                });

            if ($this->teacherSchedule) {
                $query->whereHas('class_attendance.class_schedule', function ($q) {
                    $q->where('id', $this->teacherSchedule);
                });
            }

            $this->{$property} = HomeChart::TOTAL_DATA($query, $this->period);
        }
    }

    public function mount(){
        $user = Auth::user();
        $this->teacherId = $user->teacher->id;
        $this->getDataCount();
        $this->getDataChart();
    }

    public function updateDataChart()
    {
        $this->getDataChart();

        $date = $this->attendanceHadir['date'];
        $attendanceHadir = $this->attendanceHadir['data'];
        $attendanceAlpa = $this->attendanceAlpa['data'];
        $attendanceIzin = $this->attendanceIzin['data'];
        $attendanceSakit = $this->attendanceSakit['data'];

        $this->dispatch('updateChartTeacher', [
            'hadir' => $attendanceHadir,
            'alpa' => $attendanceAlpa,
            'izin' => $attendanceIzin,
            'sakit' => $attendanceSakit,
            'date' => $date,
        ]);
    }

    public function render()
    {
        return view('livewire.home.teacher-home');
    }
}
