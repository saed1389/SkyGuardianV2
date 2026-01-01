<?php

namespace App\Livewire\User;

use Livewire\Component;

class SystemLogsPage extends Component
{
    public function render()
    {
        return view('livewire.user.system-logs-page')->layout('components.layouts.userApp');
    }
}
