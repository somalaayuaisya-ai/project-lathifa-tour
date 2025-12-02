<?php

namespace App\Livewire;

use App\Models\Package;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Enums\InquiryStatus;
use App\Models\PackageInquiry;
use Illuminate\Support\Facades\Auth;

class PackageDetailModal extends Component
{
    public bool $modalOpen = false;
    public ?array $package = null;
    public ?string $activeImage = null;

    #[On('show-package')]
    public function show(array $packageData)
    {
        if (data_get($packageData, 'id')) {
            $fullPackage = Package::with('itineraries', 'galleries')->find($packageData['id']);
            if ($fullPackage) {
                // Assign ke properti publik kelas ($this->package)
                $this->package = $fullPackage->toArray();
                $this->activeImage = $this->package['featured_image'] ?? null;
                $this->modalOpen = true;
            }
        }
    }

    // This hook is called when the modal is closed from the frontend
    public function updatedModalOpen($value): void
    {
        if (!$value) {
            $this->reset(['package', 'activeImage']);
        }
    }

    public function bookViaWA()
    {
        if (!$this->package) return;

        // 1. Siapkan Data untuk WhatsApp
        $adminPhone = "6285810975143"; // Nomor Admin Travel
        $price = number_format($this->package['price_quad'], 0, ',', '.');

        // Ambil data user jika login
        $user = Auth::user();
        $userName = $user ? $user->name : 'Tamu';

        // Format Pesan WA
        $text = "Assalamualaikum, saya {$userName}. \nSaya tertarik dengan paket *{$this->package['title']}* (Quad: Rp {$price}). \nMohon info ketersediaan seat.";

        // 2. LOGIC BARU: Simpan ke Database jika User Login
        if (Auth::check()) {
            PackageInquiry::create([
                'package_id'  => $this->package['id'],
                'user_id'     => $user->id,
                'guest_name'  => $user->name,
                'guest_phone' => $user->phone ?? '-', // Pastikan ada kolom ini di tabel users atau ganti '-'
                'message'     => $text,
                'status'      => InquiryStatus::NEW, // Sesuaikan dengan Enum Anda
            ]);

            toast()->success('Inquiry tersimpan di riwayat Anda')->push();
        }

        // 3. Redirect ke WhatsApp
        $waLink = "https://wa.me/{$adminPhone}?text=" . urlencode($text);
        $this->js("window.open('{$waLink}', '_blank');");
    }

    public function render()
    {
        return view('livewire.package-detail-modal');
    }
}
