<?php

namespace LowB\Ladmin\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class LadminGuestLayout extends Component
{
    public function render(): View
    {
        return view('ladmin::layouts.guest');
    }
}
