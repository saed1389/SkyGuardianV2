<?php

namespace App\Livewire\User;

use Livewire\Component;

class MilitaryMonitorPage extends Component
{
    public function render()
    {
        return view('livewire.user.military-monitor-page')->layout('components.layouts.userApp');
    }
}
