<?php

namespace LowB\Ladmin\Controllers;

use Illuminate\Contracts\View\View as ViewView;
use Illuminate\Support\Facades\View;
use LowB\Ladmin\Config\Facades\LadminConfig;

class DashboardController extends Controller
{
    public function index(): ViewView
    {
        return View::first([
            LadminConfig::localView('dashboard'),
            LadminConfig::themeView('dashboard')
        ]);
    }
}
