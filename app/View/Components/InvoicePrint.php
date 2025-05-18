<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

namespace App\View\Components;

use Illuminate\View\Component;

class InvoicePrint extends Component
{
    public $title;

    public function __construct($title = 'Invoice')
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('components.invoice-print');
    }
}
