<?php

namespace App\Livewire;

use Livewire\Component;

class CompliancePage extends Component
{
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.compliance-page')->layout('components.layouts.appFront');
    }
}
