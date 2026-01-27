<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class CareersPage extends Component
{
    use WithFileUploads;

    public $name, $email, $position, $cv;

    public function submitApplication()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'position' => 'required',
            'cv' => 'required|mimes:pdf|max:10240', // 10MB Max
        ]);

        // Save file: $path = $this->cv->store('cvs');

        session()->flash('message', 'Application sent successfully!');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.careers-page')->layout('components.layouts.appFront');
    }
}
