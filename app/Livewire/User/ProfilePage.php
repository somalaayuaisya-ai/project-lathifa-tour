<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Usernotnull\Toast\Concerns\WireToast;

#[Layout('components.layouts.dashboard')]
class ProfilePage extends Component
{
    use WireToast;

    public array $profileState = [];
    public array $passwordState = [];

    public function mount(): void
    {
        $this->profileState = Auth::user()->only(['name', 'email', 'phone']);
        $this->passwordState = ['current_password' => '', 'password' => '', 'password_confirmation' => ''];
    }

    public function updateProfile(UpdatesUserProfileInformation $updater): void
    {
        $this->resetErrorBag();
        $updater->update(Auth::user(), $this->profileState);
        $this->dispatch('profile-updated'); // For potential UI updates if needed
        toast()->success('Informasi profil berhasil diperbarui.')->push();
    }

    public function updatePassword(UpdatesUserPasswords $updater): void
    {
        $this->resetErrorBag();
        $updater->update(Auth::user(), $this->passwordState);
        $this->passwordState = ['current_password' => '', 'password' => '', 'password_confirmation' => ''];
        toast()->success('Password berhasil diubah.')->push();
    }

    public function render()
    {
        return view('livewire.user.profile-page');
    }
}
