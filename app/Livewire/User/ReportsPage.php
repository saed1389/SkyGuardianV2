<?php

namespace App\Livewire\User;

use Livewire\Component;

class ReportsPage extends Component
{
    public function render()
    {
        return view('livewire.user.reports-page')->layout('components.layouts.userApp');
    }
}
