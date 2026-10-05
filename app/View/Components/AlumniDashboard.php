<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\View\Component;

class AlumniDashboard extends Component
{

    public array $menuData = [];

    public function __construct()
    {

        $path = storage_path('app/menu/alumni-user-menu.json');

        if (File::exists($path)) {
            $jsonContent = File::get($path);
            $parsed = json_decode($jsonContent, true);
            $this->menuData = $parsed['menu'] ?? [];
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alumni-menu');
    }


}
