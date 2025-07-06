<?php

namespace App\Livewire\Attendance\Qrcode;

use App\Livewire\Traits\DataTable\WithBulkActions;
use App\Livewire\Traits\DataTable\WithCachedRows;
use App\Livewire\Traits\DataTable\WithPerPagePagination;
use App\Livewire\Traits\DataTable\WithSorting;
use App\Models\CheckInRecord;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class CheckIn extends Component
{
    use WithBulkActions;
    use WithPerPagePagination;
    use WithCachedRows;
    use WithSorting;

    public $filters = [
        'search' => '',
    ];

    public function deleteSelected()
    {
        $checkIn = CheckInRecord::whereIn('id', $this->selected)->get();
        $deleteCount = $checkIn->count();

        foreach ($checkIn as $data) {
            $data->delete();
        }

        $this->reset();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil!',
            'detail' => "Berhasil menghapus $deleteCount data presensi masuk.",
        ]);

        return redirect()->back();
    }

    #[On('muat-ulang')]
    #[Computed()]
    public function rows()
    {
        $query = CheckInRecord::query()
            ->when(!$this->sorts, fn($query) => $query->first())
            ->when($this->filters['search'], function ($query, $search) {
                $query->whereHas('student', function($query) use ($search){
                    $query->where('full_name', 'LIKE', "%$search%");
                });
            })->latest();

        return $this->applyPagination($query);
    }

    #[Computed()]
    public function allData()
    {
        return CheckInRecord::all();
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function render()
    {
        return view('livewire.attendance.qrcode.check-in');
    }
}
