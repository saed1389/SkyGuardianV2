<?php

namespace App\Livewire;

use Livewire\Component;

class LicensePage extends Component
{
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.license-page')->layout('components.layouts.appFront');
    }
}
