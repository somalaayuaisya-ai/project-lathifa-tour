<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Usernotnull\Toast\Concerns\WireToast;

#[Layout('components.layouts.dashboard')]
class WishlistPage extends Component
{
    use WithPagination;
    use WireToast;

    public function removeBookmark(int $packageId): void
    {
        Auth::user()->bookmarkedPackages()->detach($packageId);
        
        // No need to manually reload data, Livewire will re-render automatically
        // after the component state changes (if any) or we can force it.
        // For simplicity, we let the next render handle the update.
        
        toast()->success('Paket berhasil dihapus dari wishlist.')->push();
    }

    public function render()
    {
        $wishlistedPackages = Auth::user()
            ->bookmarkedPackages()
            ->with('galleries')
            ->latest('bookmarks.created_at')
            ->paginate(9); // 9 items for a nice 3x3 grid

        return view('livewire.user.wishlist-page', [
            'wishlistedPackages' => $wishlistedPackages,
        ]);
    }
}
