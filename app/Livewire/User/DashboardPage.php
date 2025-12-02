<?php

namespace App\Livewire\User;

use App\Models\PackageInquiry;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Usernotnull\Toast\Concerns\WireToast;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.dashboard')] 
class DashboardPage extends Component
{
    use WireToast;

    public int $wishlistCount = 0;
    public int $inquiryCount = 0;
    public Collection $wishlistedPackages;
    public ?PackageInquiry $latestInquiry = null;

    public function mount(): void
    {
        $this->loadUserData();
    }

    public function removeBookmark(int $packageId): void
    {
        $user = Auth::user();
        $user->bookmarkedPackages()->detach($packageId);
        $this->loadUserData(); // Refresh data after action
        toast()->success('Paket berhasil dihapus dari wishlist.')->push();
    }

    private function loadUserData(): void
    {
        $user = Auth::user();

        $this->wishlistCount = $user->bookmarkedPackages()->count();
        $this->inquiryCount = $user->inquiries()->count();
        
        $this->wishlistedPackages = $user->bookmarkedPackages()
                                         ->with('galleries')
                                         ->latest('bookmarks.created_at') // Sort by the created_at on the pivot table
                                         ->take(4) // Display a few recent ones
                                         ->get();

        $this->latestInquiry = $user->inquiries()
                                    ->with('package')
                                    ->latest()
                                    ->first();
    }

    public function render()
    {
        return view('livewire.user.dashboard-page');
    }
}
