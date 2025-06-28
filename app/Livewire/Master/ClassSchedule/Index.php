<?php

namespace App\Livewire\Master\ClassSchedule;

use App\Livewire\Traits\DataTable\WithBulkActions;
use App\Livewire\Traits\DataTable\WithCachedRows;
use App\Livewire\Traits\DataTable\WithPerPagePagination;
use App\Livewire\Traits\DataTable\WithSorting;
use App\Models\ClassRoom;
use App\Models\ClassSchedule;
use App\Models\SubjectStudy;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    use WithBulkActions;
    use WithPerPagePagination;
    use WithCachedRows;
    use WithSorting;

    public $filters = [
        'search' => '',
        'class_room' => '',
        'subject_study' => '',
        'start_time' => '',
        'end_time' => '',
    ];

    #[Computed()]
    public function class_rooms(){
        return ClassRoom::all(['id','name_class']);
    }

    #[Computed()]
    public function subject_studies(){
        return SubjectStudy::all(['id','name_subject']);
    }

    public function deleteSelected()
    {
        $schedules = ClassSchedule::whereIn('id', $this->selected)->get();
        $deleteCount = $schedules->count();

        foreach ($schedules as $data) {
            $data->delete();
        }

        $this->reset();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil!',
            'detail' => "Berhasil menghapus $deleteCount data jadwal kelas.",
        ]);

        return redirect()->back();
    }

    #[On('muat-ulang')]
    #[Computed()]
    public function rows()
    {
        $query = ClassSchedule::query()
            ->when(!$this->sorts, fn($query) => $query->first())
            ->when($this->filters['search'], function ($query, $search) {
                $query->whereHas('class_room', function($query) use ($search){
                    $query->where('name_class', 'LIKE', "%$search%");
                })->orWhereHas('teacher_name', function($query) use ($search){
                    $query->where('name', 'LIKE', "$search");
                })->orWhereHas('subject_study', function($query) use ($search){
                    $query->where('name_subject', 'LIKE', "$search");
                });
            })
            ->when($this->filters['class_room'], function($query, $classId){
                $query->where('class_room_id', $classId);
            })
            ->when($this->filters['subject_study'], function($query, $subjectStudyId){
                $query->where('subject_study_id', $subjectStudyId);
            })
            ->when($this->filters['start_time'], function($query, $startTime){
                $query->whereTime('start_time', '>=', $startTime);
            })
            ->when($this->filters['end_time'], function($query, $endTime){
                $query->whereTime('end_time', '<=', $endTime);
            })
            ->latest();

        return $this->applyPagination($query);
    }

    #[Computed()]
    public function allData()
    {
        return ClassSchedule::all();
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function muatUlang()
    {
        $this->dispatch('muat-ulang');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.master.class-schedule.index');
    }
}
