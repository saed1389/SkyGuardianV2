<?php

namespace App\Livewire\Back\Messages;

use App\Models\ContactMessage;
use Livewire\Component;
use Livewire\WithPagination;

class ContactSalePage extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $selectedMessage = null;

    protected $listeners = ['deleteConfirmed' => 'deleteMessage'];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function toggleStatus($id): void
    {
        $msg = ContactMessage::findOrFail($id);
        $msg->status = $msg->status == 1 ? 0 : 1;
        $msg->save();

        $this->dispatch('message', 'Status updated successfully!');
    }

    public function openModal($id): void
    {
        $this->selectedMessage = ContactMessage::findOrFail($id);
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->selectedMessage = null;
    }

    public function confirmDelete($id): void
    {
        $this->dispatch('showDeleteConfirmation', $id);
    }

    public function deleteMessage($id): void
    {
        ContactMessage::where('id', $id[0])->first()->delete();
        $this->dispatch('message', 'Message deleted successfully.');
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $messages = ContactMessage::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('message', 'like', '%' . $this->search . '%');
        })
            ->where('type', 'sales')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.back.messages.contact-sale-page', [
            'messages' => $messages
        ]);
    }
}
