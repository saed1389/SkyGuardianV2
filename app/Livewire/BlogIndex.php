<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;
use Livewire\WithPagination;

class BlogIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $category = 'all';

    public function updatingSearch(): void
    { $this->resetPage(); }
    public function updatingCategory(): void
    { $this->resetPage(); }

    public function setCategory($cat): void
    {
        $this->category = $cat;
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        $query = Blog::where('status', 1)->orderBy('published_at', 'desc');

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('title_en', 'like', '%' . $this->search . '%')
                    ->orWhere('title_tr', 'like', '%' . $this->search . '%')
                    ->orWhere('title_ee', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->category !== 'all') {
            $query->where(function($q) {
                $q->where('category_en', $this->category)
                    ->orWhere('category_tr', $this->category)
                    ->orWhere('category_ee', $this->category);
            });
        }

        $posts = $query->paginate(9);

        return view('livewire.blog-index', [
            'posts' => $posts
        ])->layout('components.layouts.appFront');
    }
}
