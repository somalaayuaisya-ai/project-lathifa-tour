<?php

namespace App\Livewire\Auth;

use App\Http\Responses\LoginResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class LoginPage extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    /**
     * The validation rules.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function login()
    {
        $this->validate();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (! Auth::attempt($credentials, $this->remember)) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        request()->session()->regenerate();

        return app(LoginResponse::class);
    }
    
    public function render()
    {
        return view('livewire.auth.login-page')
            ->layout('components.layouts.guest');
    }
}

