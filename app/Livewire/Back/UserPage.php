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
    public $modalTitle = 'Add User';
    public $editingUserId = null;

    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $phone = '';
    public $status = 'Active';

    public $airport = '';
    public $lat = '';
    public $lon = '';

    // Search
    public $search = '';

    protected function rules(): array
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string',
            'status' => 'required|in:1,0',
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
        })->where('type', 'user')->paginate(10);

        return view('livewire.back.user-page', [
            'users' => $users,
        ]);
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
        $this->status = $user->status ?? 'Active';
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
            'type' => 'user',
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
        }

        $this->closeModal();
    }

    public function deleteUser($id): void
    {
        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('message', 'User deleted successfully.');
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
            'phone', 'status', 'airport', 'lat', 'lon', 'editingUserId'
        ]);
        $this->resetValidation();
    }
}
