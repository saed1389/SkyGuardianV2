<?php

namespace App\Livewire\Back\Partials;

use Livewire\Component;

class TopBar extends Component
{
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.back.partials.top-bar');
    }
}
