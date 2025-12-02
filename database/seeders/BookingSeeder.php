<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Package;
use App\Enums\BookingStatus;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'user@lathifatour.com')->first();
        $package = Package::first();

        if ($user && $package) {
            Booking::create([
                'user_id' => $user->id,
                'package_id' => $package->id,
                'total_amount' => $package->price_quad,
                'status' => BookingStatus::PAID,
                'notes' => 'Booking pertama dari seeder.'
            ]);
        }
    }
}