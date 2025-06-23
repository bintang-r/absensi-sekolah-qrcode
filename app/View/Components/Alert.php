<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Create a new component instance.
     */
    public $type;
    public $message;
    public $detail;
    public $icon;

    public function __construct()
    {
        $this->type = session('alert.type') ?? '';
        $this->message = session('alert.message') ?? '';
        $this->detail = session('alert.detail') ?? '';

        switch (session('alert.type')) {
            case 'info':
                $this->icon = 'info-circle';
                break;
            case 'warning':
                $this->icon = 'exclamation-triangle';
                break;
            case 'danger':
                $this->icon = 'exclamation-circle';
                break;
            default:
                $this->icon = 'check';
                break;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert');
    }
}
