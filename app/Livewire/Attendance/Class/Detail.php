<?php

namespace App\Livewire\Attendance\Class;

use App\Models\ClassAttendance;
use App\Models\StudentAttendance;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Detail extends Component
{
    public $classAttendance;
    public $classAttendanceId;

    public $filters = [
        'search' => '',
        'status' => '',
    ];

    #[Computed()]
    public function student_attendances(){
        return StudentAttendance::query()
            ->when($this->filters['search'], function($query, $search){
                $query->whereHas('student', function($query) use ($search){
                    $query->where('full_name', 'LIKE', "%$search%")
                        ->orWhere('call_name', 'LIKE', "%$search%")
                        ->orWhere('nis', 'LIKE', "%$search%");
                });
            })
            ->when($this->filters['status'], function($query, $status){
                $query->where('status_attendance', $status);
            })
            ->where('class_attendance_id', $this->classAttendanceId)
            ->latest()
            ->get();
    }


    public function mount($id){
        $this->classAttendance = ClassAttendance::findOrFail($id);
        $this->classAttendanceId = $id;
    }

    public function render()
    {
        return view('livewire.attendance.class.detail');
    }
}
