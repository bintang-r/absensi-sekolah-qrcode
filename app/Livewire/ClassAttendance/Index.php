<?php

namespace App\Livewire\ClassAttendance;

use App\Livewire\Traits\DataTable\WithBulkActions;
use App\Livewire\Traits\DataTable\WithCachedRows;
use App\Livewire\Traits\DataTable\WithPerPagePagination;
use App\Livewire\Traits\DataTable\WithSorting;
use App\Models\ClassRoom;
use App\Models\ClassSchedule;
use Illuminate\Support\Facades\Auth;
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
        'name_day' => '',
    ];

    public $teacherId;

    #[Computed()]
    public function class_rooms(){
        return ClassRoom::all(['id','name_class']);
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
                });
            })
            ->when($this->filters['class_room'], function($query, $classRoom){
                $query->where('class_room_id', $classRoom);
            })
            ->when($this->filters['name_day'], function($query, $nameDay){
                $query->where('day_name', $nameDay);
            })
            ->where('teacher_id', $this->teacherId)->latest();

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
    }

    public function mount(){
        $user = Auth::user();
        $this->teacherId = $user->teacher->id;
    }

    public function render()
    {
        return view('livewire.class-attendance.index');
    }
}
