<?php

namespace App\Livewire\User\Bookings;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.dashboard')]
class MyBookingsPage extends Component
{
    use WithPagination;

    public function render()
    {
        $bookings = Auth::user()
            ->bookings()
            ->with('package')
            ->latest()
            ->paginate(5);

        return view('livewire.user.bookings.my-bookings-page', [
            'bookings' => $bookings
        ]);
    }
}
