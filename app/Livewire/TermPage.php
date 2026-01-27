<?php

namespace App\Livewire;

use Livewire\Component;

class TermPage extends Component
{
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.term-page')->layout('components.layouts.appFront');
    }
}
