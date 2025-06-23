<?php

namespace App\Livewire\Traits\DataTable;

use Livewire\WithPagination;

trait WithPerPagePagination
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;

    public function mountWithPerPagePagination()
    {
        $this->perPage = session()->get('perPage', $this->perPage);
    }

    public function updatedPerPage($value)
    {
        if ($this->perPage != 'all') {
            session()->put('perPage', $value);
        }
    }

    public function applyPagination($query)
    {
        if ($this->perPage == 'all') {
            return $query->paginate(100);
        }

        return $query->paginate($this->perPage);
    }
}
