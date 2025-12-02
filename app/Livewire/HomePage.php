<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\Testimonial;
use App\Queries\SearchPackagesQuery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;
use Livewire\WithPagination;

class HomePage extends Component
{
    use WireToast;
    use WithPagination;

    // Dropdown options
    public $months = [];
    public $types = ['Umroh Reguler', 'Umroh Plus'];

    // Properties for interactivity
    public array $wishlistedPackageIds = [];

    // Properties for filtering (state)
    public string $filterMonth = '';
    public string $filterType = '';

    public function mount()
    {
        if (Auth::check()) {
            $this->wishlistedPackageIds = Auth::user()->bookmarkedPackages()->pluck('packages.id')->toArray();
        }
        $this->months = Package::select(DB::raw("DATE_FORMAT(departure_date, '%Y-%m') as month_value"), DB::raw("CONCAT(DATE_FORMAT(departure_date, '%M %Y')) as month_name"))
            ->where('departure_date', '>=', now())->distinct()->orderBy('month_value', 'asc')->get();
    }

    public function toggleWishlist(int $packageId)
    {
        if (!Auth::check()) {
            toast()->info('Silakan masuk untuk menggunakan fitur wishlist.')->push();
            return $this->redirect(route('login'), navigate: true);
        }
        Auth::user()->bookmarkedPackages()->toggle($packageId);
        $this->wishlistedPackageIds = Auth::user()->bookmarkedPackages()->pluck('packages.id')->toArray();
        toast()->success('Status wishlist berhasil diperbarui.')->push();
        $this->dispatch('wishlist-updated');
    }

    public function showPackage(int $packageId): void
    {
        // Find the package from the collection already loaded in render()
        $packages = app(SearchPackagesQuery::class)->get([
            'month' => $this->filterMonth,
            'type' => $this->filterType,
            'status' => 'true',
        ], 9);

        $package = $packages->find($packageId);

        if ($package) {
            $this->dispatch('show-package', packageData: $package->toArray());
        }
    }

    public function render(SearchPackagesQuery $searchPackagesQuery)
    {
        $filters = [
            'month' => $this->filterMonth,
            'type' => $this->filterType,
            'status' => 'true',
        ];

        $packages = $searchPackagesQuery->get($filters, 9);
        $testimonials = Testimonial::where('is_show', true)->latest()->take(6)->get();

        return view('livewire.home-page', [
            'packages' => $packages,
            'testimonials' => $testimonials,
        ])->layout('components.layouts.app');
    }
}
