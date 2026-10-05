<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\View\Component;

class SuratKeteranganMenu extends Component
{
    public array $menuData = [];

    public function __construct()
    {

        $path = resource_path('menu/suratketerangan-admin-menu.json');

        if (File::exists($path)) {
            $jsonContent = File::get($path);
            $parsed = json_decode($jsonContent, true);
            $this->menuData = $parsed['menu'] ?? [];
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.suratketerangan-menu');
    }
}
