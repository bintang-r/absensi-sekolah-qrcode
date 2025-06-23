<?php

namespace App\Livewire\Traits\DataTable;

trait WithBulkActions
{
    public $selectPage = false;

    public $selectAll = false;

    public $selected = [];

    public function renderingWithBulkActions()
    {
        if ($this->selectAll) {
            $this->selectPageRows();
        }
    }

    public function updatedSelected()
    {
        $this->selectAll = false;
        $this->selectPage = false;
    }

    public function updatedSelectPage($value)
    {
        if ($value) {
            return $this->selectPageRows();
        }

        $this->selectAll = false;
        $this->selected = [];
    }

    public function selectPageRows()
    {
        if ($this->selectAll) {
            $this->selected = $this->allData->pluck('id')->map(fn ($id) => (string) $id)->all();
        } else {
            $this->selected = $this->rows->pluck('id')->map(fn ($id) => (string) $id)->all();
        }
    }

    public function selectedAll()
    {
        $this->selected = $this->allData->pluck('id')->map(fn ($id) => (string) $id)->all();
        $this->selectAll = true;
    }
}
