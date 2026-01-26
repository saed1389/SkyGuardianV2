<?php

namespace App\Livewire\Back\Partials;

use App\Models\Blog;
use Livewire\Component;

class Sidebar extends Component
{
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        $blogCount = Blog::where('status', 0)->count();
        return view('livewire.back.partials.sidebar', [
            'blogCount' => $blogCount,
        ]);
    }
}
