<?php

namespace App\Livewire\User;

use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        return view('livewire.user.home-page')->layout('components.layouts.userApp');
    }
}
