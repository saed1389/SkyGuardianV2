<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;

class BlogShow extends Component
{
    public $post;

    public function mount($slug): void
    {
        $this->post = Blog::where('status', 1)
            ->where(function($query) use ($slug) {
                $query->where('slug_en', $slug)
                    ->orWhere('slug_tr', $slug)
                    ->orWhere('slug_ee', $slug);
            })
            ->firstOrFail();
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.blog-show')
            ->layout('components.layouts.appFront');
    }
}
