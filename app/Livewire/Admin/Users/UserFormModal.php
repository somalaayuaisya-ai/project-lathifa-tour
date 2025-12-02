<?php

namespace App\Livewire\Admin\Users;

use App\Enums\UserRole;
use App\Models\User;
use App\Services\UserService;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UserFormModal extends Component
{
    public bool $modalOpen = false;
    public ?User $user = null;
    public ?int $userId = null;

    // Form fields
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $role = 'user';
    public string $password = '';
    public string $password_confirmation = '';

    protected function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->userId)],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', Rule::in(array_column(UserRole::cases(), 'value'))],
        ];

        // Password is required for new users, but optional for existing users
        $passwordRule = $this->userId
            ? ['nullable', 'string', 'confirmed', Password::defaults()]
            : ['required', 'string', 'confirmed', Password::defaults()];
        
        $rules['password'] = $passwordRule;

        return $rules;
    }

    #[On('open-user-form')]
    public function openModal(?int $userId = null): void
    {
        $this->resetValidation();
        $this->resetForm();

        if ($userId) {
            $this->user = User::findOrFail($userId);
            $this->fillForm($this->user);
        }

        $this->modalOpen = true;
    }

    public function closeModal(): void
    {
        $this->modalOpen = false;
    }

    public function save(UserService $userService): void
    {
        $validatedData = $this->validate();

        if ($this->user) {
            $userService->update($this->user, $validatedData);
        } else {
            $userService->create($validatedData);
        }

        $this->dispatch('user-saved');
        $this->closeModal();
    }

    protected function fillForm(User $user): void
    {
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->role = $user->role->value;
    }

    protected function resetForm(): void
    {
        $this->user = null;
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->role = 'user';
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function render()
    {
        return view('livewire.admin.users.user-form-modal');
    }
}
