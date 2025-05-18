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
    public $filename;

    public function __construct($title = 'Invoice', $filename = 'invoice')
    {
        $this->title = $title;
        $this->filename = $filename;
    }

    public function render()
    {
        return view('components.invoice-print');
    }
}
