<?php

namespace App\Livewire\Master\ClassAdvisor;

use App\Livewire\Traits\DataTable\WithBulkActions;
use App\Livewire\Traits\DataTable\WithCachedRows;
use App\Livewire\Traits\DataTable\WithPerPagePagination;
use App\Livewire\Traits\DataTable\WithSorting;
use App\Models\ClassAdvisor;
use App\Models\ClassRoom;
use App\Models\Teacher;
use Exception;
use Illuminate\Support\Facades\DB;
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
    ];

    public $teacherAdvisor = [];

    public function saveAdvisor($id)
    {
        $classRoom = ClassRoom::findOrFail($id);
        $teacherId = $this->teacherAdvisor[$id] ?? null;

        if (!$teacherId) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Gagal!',
                'detail' => "Guru belum dipilih.",
            ]);
            return;
        }

        $teacher = Teacher::findOrFail($teacherId);

        try {
            DB::beginTransaction();

            $classAdvisor = ClassAdvisor::where('class_room_id', $classRoom->id)->first();

            if ($classAdvisor) {
                $classAdvisor->update([
                    'teacher_id' => $teacher->id,
                ]);
            } else {
                ClassAdvisor::create([
                    'class_room_id' => $classRoom->id,
                    'teacher_id' => $teacher->id,
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            logger()->error(
                '[class advisor] ' .
                    (auth()->user()->username ?? 'guest') .
                    ' gagal mengubah wali kelas',
                [$e->getMessage()]
            );

            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Gagal!',
                'detail' => "Gagal mengubah data wali kelas.",
            ]);
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil!',
            'detail' => "Berhasil mengubah data wali kelas.",
        ]);

        return redirect()->back();
    }

    #[Computed()]
    public function teachers(){
        return Teacher::all(['id','name']);
    }

    #[On('muat-ulang')]
    #[Computed()]
    public function rows()
    {
        $query = ClassRoom::query()
            ->when(!$this->sorts, fn($query) => $query->first())
            ->when($this->filters['search'], function ($query, $search) {
                $query->where('class_name', 'LIKE', "%$search%");
            })->latest();

        return $this->applyPagination($query);
    }

    #[Computed()]
    public function allData()
    {
        return ClassRoom::all();
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

    public function mount()
    {
        $classAdvisors = ClassAdvisor::all();
        foreach ($classAdvisors as $advisor) {
            $this->teacherAdvisor[$advisor->class_room_id] = $advisor->teacher_id;
        }
    }

    public function render()
    {
        return view('livewire.master.class-advisor.index');
    }
}
