<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Actions\Fortify\CreateNewUser;
use App\Http\Responses\RegisterResponse;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class RegisterPage extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    public function register(Request $request, CreatesNewUsers $creator)
    {
        // Manually set the request data from component properties
        $request->merge([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ]);

        // The CreateNewUser action already has validation logic
        $user = $creator->create($request->all());

        // Log the user in
        Auth::login($user);

        // Return the response Fortify expects
        return app(RegisterResponse::class);
    }

    public function render()
    {
        return view('livewire.auth.register-page')
            ->layout('components.layouts.guest');
    }
}
