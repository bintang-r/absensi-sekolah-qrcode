<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LandingPage extends Component
{
    /**
     * Create a new component instance.
     */
    public $title = 'Halaman Utama';

    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.landing-page');
    }
}
