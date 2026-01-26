<?php

namespace App\Livewire\Back;

use App\Models\Partner;
use File;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PartnerPage extends Component
{
    use WithPagination, WithFileUploads;

    public $showModal = false;
    public $modalTitle = 'Add Partner';
    public $editingPartnerId = null;

    public $name;

    public $image, $existingImage, $status = 1;
    public $search = '';

    protected $listeners = [
        'refreshTable' => '$refresh',
        'deletePartner' => 'deletePartner'
    ];

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'status' => 'required|in:1,0',
            'image' => $this->editingPartnerId ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];
    }

    public function toggleStatus($id): void
    {
        $partner = Partner::findOrFail($id);
        $partner->status = $partner->status == 1 ? 0 : 1;

        $partner->save();

        $this->dispatch('message', 'Status updated successfully!');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        $partners = Partner::when($this->search, function ($query) {
            return $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        })->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.back.partner-page', [
            'partners' => $partners
        ]);
    }

    public function openAddModal(): void
    {
        $this->resetForm();
        $this->modalTitle = 'Add Partner';
        $this->showModal = true;
    }

    public function openEditModal($id): void
    {
        $this->resetForm();
        $partner = Partner::findOrFail($id);
        $this->editingPartnerId = $id;

        $this->name = $partner->name;
        $this->status = $partner->status;
        $this->existingImage = $partner->image;

        $this->modalTitle = 'Edit Partner';
        $this->showModal = true;
    }

    public function savePartner(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'status' => $this->status,
        ];


        if ($this->image) {
            if ($this->editingPartnerId && $this->existingImage) {
                $oldPath = public_path($this->existingImage);
                if (File::exists($oldPath)) { File::delete($oldPath); }
            }

            $imageName = time() . '.' . $this->image->getClientOriginalExtension();
            $this->image->storeAs('uploads/partners', $imageName, 'public');
            $data['image'] = 'uploads/partners/' . $imageName;
        }

        if ($this->editingPartnerId) {
            Partner::findOrFail($this->editingPartnerId)->update($data);
            $this->dispatch('message', 'Partner updated successfully.');
        } else {
            Partner::create($data);
            $this->dispatch('message', 'Partner created successfully.');
        }

        $this->closeModal();
        $this->dispatch('refreshTable');
    }

    public function confirmDelete($id): void
    {
        $this->dispatch('showDeleteConfirmation', $id);
    }

    public function deletePartner($id): void
    {
        $partner = Partner::where('id', $id)->first();

        if ($partner->image) {
            $imagePath = asset($partner->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $partner->delete();
        $this->dispatch('message', 'Partner deleted successfully.');
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
            'name', 'image', 'editingPartnerId', 'image', 'existingImage'
        ]);
        $this->status = 1;
        $this->resetValidation();
    }
}
