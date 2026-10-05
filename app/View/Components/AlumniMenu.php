<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\File;

class AlumniMenu extends Component
{
    public array $menuData = [];

    public function __construct()
    {
        $path = storage_path('app/menu/alumni-user-menu.json');

        if (File::exists($path)) {
            $parsed = json_decode(
                File::get($path),
                true
            );
            $this->menuData = $parsed['menu'] ?? [];
        }
    }

    public function render()
    {
        return view('components.alumni-menu');
    }
}
