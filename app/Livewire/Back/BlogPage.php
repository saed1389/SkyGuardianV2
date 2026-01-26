<?php

namespace App\Livewire\Back;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class BlogPage extends Component
{
    use WithPagination, WithFileUploads;

    public $showModal = false;
    public $modalTitle = 'Add Blog Post';
    public $editingBlogId = null;

    public $title_en, $title_tr, $title_ee;
    public $excerpt_en, $excerpt_tr, $excerpt_ee;
    public $body_en, $body_tr, $body_ee;
    public $category_en, $category_tr, $category_ee;

    public $image, $existingImage, $published_at, $status = 1, $resource;
    public $search = '';

    protected $listeners = [
        'refreshTable' => '$refresh',
        'deleteBlog' => 'deleteBlog'
    ];

    protected function rules(): array
    {
        return [
            'title_en' => 'required|string|max:255',
            'title_tr' => 'required|string|max:255',
            'title_ee' => 'required|string|max:255',
            'body_en' => 'required',
            'body_tr' => 'required',
            'body_ee' => 'required',
            'category_en' => 'required',
            'category_tr' => 'required',
            'category_ee' => 'required',
            'status' => 'required|in:1,0',
            'image' => $this->editingBlogId ? 'nullable|image|max:2048' : 'required|image|max:2048',
            'resource' => 'nullable|string',
            'published_at' => 'nullable',
        ];
    }

    public function toggleStatus($id): void
    {
        $blog = Blog::findOrFail($id);
        $blog->status = $blog->status == 1 ? 0 : 1;
        if ($blog->published_at == null) {
            $blog->published_at = Carbon::now();
        }
        $blog->save();

        $this->dispatch('message', 'Status updated successfully!');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        $blogs = Blog::where(function ($query) {
            $query->where('title_en', 'like', '%' . $this->search . '%')
                ->orWhere('category_en', 'like', '%' . $this->search . '%');
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.back.blog-page', ['blogs' => $blogs]);
    }

    public function openAddModal(): void
    {
        $this->resetForm();
        $this->modalTitle = 'Add Blog Post';
        $this->showModal = true;
    }

    public function openEditModal($id): void
    {
        $this->resetForm();
        $blog = Blog::findOrFail($id);
        $this->editingBlogId = $id;

        foreach (['en', 'tr', 'ee'] as $lang) {
            $this->{"title_$lang"} = $blog->{"title_$lang"};
            $this->{"excerpt_$lang"} = $blog->{"excerpt_$lang"};
            $this->{"body_$lang"} = $blog->{"body_$lang"};
            $this->{"category_$lang"} = $blog->{"category_$lang"};
        }

        $this->status = $blog->status;
        $this->resource = $blog->resource;
        $this->existingImage = $blog->image;
        $this->published_at = $blog->published_at ? date('Y-m-d\TH:i', strtotime($blog->published_at)) : null;

        $this->modalTitle = 'Edit Blog Post';
        $this->showModal = true;
    }

    public function saveBlog(): void
    {
        $this->validate();

        $data = [
            'status' => $this->status,
            'resource' => $this->resource,
            'published_at' => $this->published_at ?: now(),
        ];

        foreach (['en', 'tr', 'ee'] as $lang) {
            $data["title_$lang"] = $this->{"title_$lang"};
            $data["slug_$lang"] = Str::slug($this->{"title_$lang"});
            $data["excerpt_$lang"] = $this->{"excerpt_$lang"};
            $data["body_$lang"] = $this->{"body_$lang"};
            $data["category_$lang"] = $this->{"category_$lang"};
        }

        if ($this->image) {
            if ($this->editingBlogId && $this->existingImage) {
                $oldPath = public_path($this->existingImage);
                if (File::exists($oldPath)) { File::delete($oldPath); }
            }

            $imageName = time() . '.' . $this->image->getClientOriginalExtension();
            $this->image->storeAs('uploads/blog', $imageName, 'public');
            $data['image'] = 'uploads/blog/' . $imageName;
        }

        if ($this->editingBlogId) {
            Blog::findOrFail($this->editingBlogId)->update($data);
            $this->dispatch('message', 'Blog updated successfully.');
        } else {
            Blog::create($data);
            $this->dispatch('message', 'Blog created successfully.');
        }

        $this->closeModal();
        $this->dispatch('refreshTable');
    }

    public function confirmDelete($id): void
    {
        $this->dispatch('showDeleteConfirmation', $id);
    }

    public function deleteBlog($id): void
    {
        $blog = Blog::where('id', $id)->first();

        if ($blog->image) {
            $imagePath = asset($blog->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $blog->delete();
        $this->dispatch('message', 'Post deleted successfully.');
        $this->dispatch('refreshTable');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset([
            'title_en', 'title_tr', 'title_ee', 'excerpt_en', 'excerpt_tr', 'excerpt_ee',
            'body_en', 'body_tr', 'body_ee', 'category_en', 'category_tr', 'category_ee',
            'image', 'editingBlogId', 'existingImage', 'resource', 'published_at'
        ]);
        $this->status = 1;
        $this->resetValidation();
    }
}
