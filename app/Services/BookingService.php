<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookingService
{
    public function create(array $data): Booking
    {
        return DB::transaction(fn () => Booking::create($data));
    }

    public function update(Booking $booking, array $data): Booking
    {
        $booking->update($data);
        return $booking;
    }

    public function attachPaymentProof(Booking $booking, UploadedFile $file): Booking
    {
        return DB::transaction(function () use ($booking, $file) {
            // Delete old proof if it exists
            if ($booking->payment_proof_url) {
                Storage::disk('public')->delete($booking->payment_proof_url);
            }

            // Store the new file and update the record
            $path = $file->store('bookings/proofs', 'public');
            $booking->update([
                'payment_proof_url' => $path,
                'status' => \App\Enums\BookingStatus::PAID,
            ]);

            return $booking;
        });
    }
}
