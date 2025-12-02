<?php

namespace App\Livewire\Admin\Bookings;

use App\Models\Booking;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

#[Layout('components.layouts.dashboard')]
class ManageBookings extends Component
{
    use WithPagination;
    use WireToast;

    #[On('booking-saved')]
    public function onBookingSaved(): void
    {
        toast()->success('Booking berhasil disimpan.')->push();
    }

    public function render()
    {
        // For simplicity, we fetch all bookings. Filtering can be added later.
        $bookings = Booking::with(['user', 'package'])
            ->latest()
            ->paginate(15);
            
        return view('livewire.admin.bookings.manage-bookings', [
            'bookings' => $bookings
        ]);
    }
}
