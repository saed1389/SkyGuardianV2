<?php

namespace App\Livewire\User;

use Livewire\Component;

class AircraftDatabasePage extends Component
{
    public function render()
    {
        return view('livewire.user.aircraft-database-page')->layout('components.layouts.userApp');
    }
}
