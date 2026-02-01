<?php

namespace App\Livewire\Back\Messages;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Career; // Ensure you have this Model created
use Illuminate\Support\Facades\Storage;

class CareersPage extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $selectedCareer = null;

    protected $listeners = ['deleteConfirmed' => 'deleteCareer'];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function toggleStatus($id): void
    {
        $career = Career::findOrFail($id);
        $career->status = $career->status == 1 ? 0 : 1;
        $career->save();

        $this->dispatch('message', 'Status updated successfully!');
    }

    public function openModal($id): void
    {
        $this->selectedCareer = Career::findOrFail($id);
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->selectedCareer = null;
    }

    public function confirmDelete($id): void
    {
        $this->dispatch('showDeleteConfirmation', $id);
    }

    public function deleteCareer($id): void
    {
        $career = Career::findOrFail($id);

        if ($career[0]->cv) {
            @unlink($career[0]->cv);
        }

        $career[0]->delete();
        $this->dispatch('message', 'Career application deleted successfully.');
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $careers = Career::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('position', 'like', '%' . $this->search . '%');
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.back.messages.careers-page', [
            'careers' => $careers
        ]);
    }
}
