<?php

namespace App\Livewire\User\Bookings;

use App\Models\Booking;
use App\Services\BookingService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Usernotnull\Toast\Concerns\WireToast;

#[Layout('components.layouts.dashboard')]
class ViewBookingPage extends Component
{
    use WithFileUploads;
    use WireToast;

    public Booking $booking;
    public $paymentProofUpload = null;

    protected function rules()
    {
        return [
            'paymentProofUpload' => ['required', 'image', 'max:2048'], // 2MB Max
        ];
    }
    
    public function mount(Booking $booking): void
    {
        // Eager load relationships for display
        $this->booking = $booking->load(['package.itineraries', 'user']);
        
        // Authorize to ensure the user owns this booking
        $this->authorize('view', $this->booking);
    }

    public function uploadProof(BookingService $bookingService): void
    {
        $this->validate();

        try {
            $bookingService->attachPaymentProof($this->booking, $this->paymentProofUpload);
            $this->paymentProofUpload = null; // Clear the file input
            $this->booking->refresh(); // Refresh booking data to get new status
            toast()->success('Bukti pembayaran berhasil di-upload.')->push();
        } catch (\Exception $e) {
            toast()->error('Gagal meng-upload bukti pembayaran.')->push();
        }
    }

    public function render()
    {
        return view('livewire.user.bookings.view-booking-page');
    }
}
