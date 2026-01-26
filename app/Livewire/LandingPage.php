<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Blog; // Import the model

class LandingPage extends Component
{
    // Form properties
    public $name = '';
    public $email = '';
    public $company = '';
    public $message = '';

    public function submitDemo(): void
    {
        $this->validate(['name' => 'required|min:3', 'email' => 'required|email']);
        // Email logic...
        $this->reset(['name', 'email', 'company']);
        $this->dispatch('close-modal');
    }

    public function submitContact(): void
    {
        $this->validate(['name' => 'required', 'email' => 'required|email', 'message' => 'required']);
        // Email logic...
        $this->reset(['name', 'email', 'message']);
        $this->dispatch('close-modal');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        // Fetch latest 3 active posts from Database
        $recentPosts = Blog::where('status', 1)
            //->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('livewire.landing-page', [
            'recentPosts' => $recentPosts
        ])->layout('components.layouts.appFront');
    }
}
