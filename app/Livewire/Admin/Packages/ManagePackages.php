<?php

namespace App\Livewire\Admin\Packages;

use App\Models\Package;
use App\Queries\SearchPackagesQuery;
use App\Services\PackageService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

#[Layout('components.layouts.dashboard')]
class ManagePackages extends Component
{
    use WithPagination;
    use WireToast;

    public string $search = '';
    public string $filterStatus = ''; // 'true' for active, 'false' for inactive, '' for all
    public string $sortBy = 'departure_date';
    public string $sortDirection = 'desc';
    public int $perPage = 10; // New explicit perPage property

    protected $queryString = ['search', 'filterStatus', 'sortBy', 'sortDirection']; // Removed perPage

    protected PackageService $packageService;
    protected SearchPackagesQuery $searchPackagesQuery;

    public function boot(PackageService $packageService, SearchPackagesQuery $searchPackagesQuery): void
    {
        $this->packageService = $packageService;
        $this->searchPackagesQuery = $searchPackagesQuery;
    }

    // Listener for when a package is saved in the modal
    #[On('package-saved')]
    public function packageSaved(): void
    {
        $this->resetPage(); // Reset pagination to show new/updated item
        toast()->success('Paket berhasil disimpan.')->push();
    }

    public function deletePackage(Package $package): void
    {
        $this->authorize('delete', $package);

        // Confirmation should be handled in frontend (e.g., Alpine.js confirm dialog)
        $package->delete();
        toast()->success('Paket berhasil dihapus.')->push();
    }

    public function toggleActive(Package $package): void
    {
        $this->authorize('update', $package); // Authorization for updating status

        $this->packageService->toggleActive($package);
        toast()->success('Status paket berhasil diperbarui.')->push();
    }

    public function toggleSortDirection(): void
    {
        $this->sortDirection = ($this->sortDirection === 'asc' ? 'desc' : 'asc');
    }

    public function updated($propertyName): void
    {
        // Reset pagination when any filter/search changes
        $this->resetPage();
    }

    public function render()
    {
        $this->authorize('viewAny', Package::class);

        $filters = [
            'search' => $this->search,
            'status' => $this->filterStatus,
            'sortBy' => $this->sortBy,
            'sortDirection' => $this->sortDirection,
        ];

        $packages = $this->searchPackagesQuery->get($filters, $this->perPage);

        return view('livewire.admin.packages.manage-packages', [
            'packages' => $packages,
        ]);
    }
}
