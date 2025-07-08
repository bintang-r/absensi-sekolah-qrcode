<?php

namespace App\Livewire\Home;

use App\Helpers\HomeChart;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public function getLoginHistories()
    {
        $user = User::query();
        return $user->whereNotNull('last_login_time')
            ->orderBy('last_login_time', 'DESC')
            ->limit(20)
            ->get();
    }


    public function render()
    {
        return view('livewire.home.index', [
            'login_history' => $this->getLoginHistories(),
        ]);
    }
}
