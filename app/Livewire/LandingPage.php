<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Blog;

class LandingPage extends Component
{
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
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
