<?php

namespace App\Livewire\Teacher;

use App\Models\Teacher;
use Livewire\Component;

class Detail extends Component
{
    public $teacher;

    public function mount($id){
        $this->teacher = Teacher::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.teacher.detail');
    }
}
