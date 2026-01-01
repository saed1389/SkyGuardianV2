<?php

namespace App\Livewire\User;

use Livewire\Component;

class ThreatAnalysisPage extends Component
{
    public function render()
    {
        return view('livewire.user.threat-analysis-page')->layout('components.layouts.userApp');
    }
}
