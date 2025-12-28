<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MemberPage extends Component
{
    use WithPagination;

    public $showModal = false;
    public $modalTitle = 'Add Member';
    public $editingUserId = null;
    public $deleteUserId = null;

    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $phone = '';
    public $status = 'Active';

    public $search = '';
    public $showDeleteModal = false;

    protected $listeners = [
        'refreshTable' => '$refresh',
        'deleteConfirmed' => 'deleteUser',
        'deleteCancelled' => 'cancelDelete',
    ];

    protected function rules(): array
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string',
            'status' => 'required',

        ];

        if (!$this->editingUserId) {
            $rules['password'] = 'required|min:8|confirmed';
            $rules['password_confirmation'] = 'required';
        } else {
            $rules['password'] = 'nullable|min:8|confirmed';
            $rules['password_confirmation'] = 'nullable';

            $rules['email'] = 'required|email|unique:users,email,' . $this->editingUserId;
        }

        return $rules;
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        $users = User::when($this->search, function ($query) {
            return $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('airport', 'like', '%' . $this->search . '%');
            });
        })->where('type', 'user')->where('admin_id', Auth::user()->id)->paginate(10);

        return view('livewire.user.member-page', [
            'users' => $users,
        ])->layout('components.layouts.userApp');
    }

    public function openAddModal(): void
    {
        $this->resetForm();
        $this->modalTitle = 'Add Member';
        $this->editingUserId = null;
        $this->showModal = true;
    }

    public function openEditModal($id): void
    {
        $user = User::findOrFail($id);

        $this->editingUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->status = $user->status ?? 'Active';

        $this->modalTitle = 'Edit Member';
        $this->showModal = true;
    }

    public function saveUser(): void
    {
        $validated = $this->validate();
        if ($validated['status'] == 'Active' || $validated['status'] == 1) {
            $status = 1;
        } else {
            $status = 0;
        }
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'status' => $status,
            'airport' => Auth::user()->airport,
            'lat' => Auth::user()->lat,
            'lon' => Auth::user()->lon,
            'type' => 'user',
            'admin_id' => Auth::user()->id,
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        if ($this->editingUserId) {

            $user = User::findOrFail($this->editingUserId);
            $user->update($userData);
            session()->flash('message', 'User updated successfully.');
        } else {
            $userData['password'] = Hash::make($validated['password']);
            User::create($userData);
            session()->flash('message', 'User created successfully.');

            $this->resetPage();
        }

        $this->closeModal();

        $this->dispatch('refreshTable');
    }

    public function confirmDelete($id): void
    {
        $this->deleteUserId = $id;
        $this->dispatch('showDeleteConfirmation', $id);
    }

    public function deleteUser(): void
    {
        if ($this->deleteUserId) {
            $user = User::findOrFail($this->deleteUserId);
            $user->delete();

            session()->flash('message', 'User deleted successfully.');
            $this->deleteUserId = null;
            $this->showDeleteModal = false;
        }
    }

    public function cancelDelete(): void
    {
        $this->deleteUserId = null;
        $this->showDeleteModal = false;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset([
            'name', 'email', 'password', 'password_confirmation',
            'phone', 'status', 'editingUserId'
        ]);
        $this->resetValidation();
    }
}
