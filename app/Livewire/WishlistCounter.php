<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class WishlistCounter extends Component
{
    public int $count = 0;

    public function mount(): void
    {
        $this->updateCount();
    }

    #[On('wishlist-updated')]
    public function updateCount(): void
    {
        if (Auth::check()) {
            $this->count = Auth::user()->bookmarkedPackages()->count();
        } else {
            $this->count = 0;
        }
    }

    public function render()
    {
        return view('livewire.wishlist-counter');
    }
}
