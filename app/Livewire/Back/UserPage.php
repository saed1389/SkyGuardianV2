<?php

namespace App\Livewire\Back;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserPage extends Component
{
    use WithPagination;

    public $showModal = false;
    public $showMemberModal = false;
    public $modalTitle = 'Add User';
    public $memberModalTitle = 'Members List';
    public $editingUserId = null;
    public $viewingAdminId = null;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $phone = '';
    public $status = 1;
    public $last_login = '';
    public $airport = '';
    public $lat = '';
    public $lon = '';

    public $search = '';

    public $members = [];
    public $adminName = '';

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
            'status' => 'required|in:1,0',
            'last_login' => 'nullable|date',
            'airport' => 'nullable|string|max:255',
            'lat' => 'nullable|numeric',
            'lon' => 'nullable|numeric',
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
        })->where('admin_id', 0)
        ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.back.user-page', [
            'users' => $users
        ]);
    }

    public function openMemberModal($adminId): void
    {
        $admin = User::findOrFail($adminId);

        $this->viewingAdminId = $adminId;
        $this->adminName = $admin->name;
        $this->members = User::where('admin_id', $adminId)
            ->orderBy('created_at', 'desc')
            ->get();

        $this->memberModalTitle = "Members for " . $admin->name;
        $this->showMemberModal = true;
    }

    public function openAddModal(): void
    {
        $this->resetForm();
        $this->modalTitle = 'Add User';
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
        $this->status = $user->status ?? 1;
        $this->last_login = $user->last_login ? $user->last_login->format('Y-m-d') : '';
        $this->airport = $user->airport ?? '';
        $this->lat = $user->lat ?? '';
        $this->lon = $user->lon ?? '';

        $this->modalTitle = 'Edit User';
        $this->showModal = true;
    }

    public function saveUser(): void
    {
        $validated = $this->validate();

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'status' => $validated['status'],
            'airport' => $validated['airport'],
            'lat' => $validated['lat'],
            'lon' => $validated['lon'],
        ];

        if (!empty($validated['last_login'])) {
            $userData['last_login'] = $validated['last_login'];
        }

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        if ($this->editingUserId) {

            $user = User::findOrFail($this->editingUserId);
            $user->update($userData);
            session()->flash('message', 'User updated successfully.');
        } else {
            $userData['password'] = Hash::make($validated['password']);
            $userData['role'] = 'admin';
            User::create($userData);
            session()->flash('message', 'User created successfully.');

            $this->resetPage();
        }

        $this->closeModal();
        $this->dispatch('refreshTable');
    }

    public function deleteUser($id = null): void
    {
        if ($id === null) {
            $id = $this->deleteUserId;
        }

        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('message', 'User deleted successfully.');
        $this->dispatch('refreshTable');
        $this->deleteUserId = null;
    }

    public function confirmDelete($id): void
    {
        $this->deleteUserId = $id;
        $this->dispatch('showDeleteConfirmation', $id);
    }

    public function cancelDelete(): void
    {
        $this->deleteUserId = null;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function memberModalClose(): void
    {
        $this->showMemberModal = false;
        $this->reset(['viewingAdminId', 'members', 'adminName']);
    }

    private function resetForm(): void
    {
        $this->reset([
            'name', 'email', 'password', 'password_confirmation',
            'phone', 'status', 'last_login', 'airport', 'lat', 'lon', 'editingUserId'
        ]);
        $this->resetValidation();
        $this->status = 1;
    }
}
