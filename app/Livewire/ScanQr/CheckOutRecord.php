<?php

namespace App\Livewire\ScanQr;

use App\Livewire\Traits\DataTable\WithBulkActions;
use App\Livewire\Traits\DataTable\WithCachedRows;
use App\Livewire\Traits\DataTable\WithPerPagePagination;
use App\Livewire\Traits\DataTable\WithSorting;
use App\Models\CheckOutRecord as ModelsCheckOutRecord;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class CheckOutRecord extends Component
{
    use WithBulkActions;
    use WithPerPagePagination;
    use WithCachedRows;
    use WithSorting;

    public $filters = [
        'search' => '',
        'start_date' => '',
        'end_date' => '',
    ];

    #[On('muat-ulang','reload-check-out')]
    #[Computed()]
    public function rows()
    {
        $query = ModelsCheckOutRecord::query()
            ->when(!$this->sorts, fn($query) => $query->first())
            ->when($this->filters['search'], function ($query, $search) {
                $query->whereHas('student', function($query) use ($search){
                    $query->where('full_name', 'LIKE', "%$search%")
                    ->orWhere('nis', 'LIKE', "%$search%");
                });
            })->when($this->filters['start_date'], function($query, $startDate){
                $query->whereDate('attendance_date', $startDate);
            })->when($this->filters['end_date'], function($query, $endDate){
                $query->whereDate('attendance_date', $endDate);
            })->latest();

        return $this->applyPagination($query);
    }

    #[Computed()]
    public function allData()
    {
        return ModelsCheckOutRecord::all();
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset('filters');
        $this->filters['start_date'] = Carbon::now()->format('Y-m-d');
    }

    public function muatUlang()
    {
        $this->dispatch('muat-ulang');
    }

    public function mount(){
        $this->filters['start_date'] = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.scan-qr.check-out-record');
    }
}
