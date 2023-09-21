<?php

namespace LowB\Ladmin\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AuthLayout extends Component
{
    public function render(): View
    {
        return view('ladmin::layouts.auth');
    }
}
