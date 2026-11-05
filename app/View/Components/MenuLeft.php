<?php

namespace App\View\Components;

use Illuminate\Support\Facades\File;
use Illuminate\View\Component;

class MenuLeft extends Component
{
  public array $menuData = [];

  public function __construct()
  {
    $json = File::get(
      resource_path('menu/tracer_laporan.json')
    );

    $data = json_decode($json, true);

    $this->menuData = $data['menu'] ?? [];
  }

  public function render()
  {
    return view('components.menu_left');
  }
}
