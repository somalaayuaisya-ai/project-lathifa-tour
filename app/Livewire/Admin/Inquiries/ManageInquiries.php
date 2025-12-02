<?php

namespace App\Livewire\Admin\Inquiries;

use App\Enums\InquiryStatus;
use App\Models\PackageInquiry;
use App\Queries\SearchInquiriesQuery;
use App\Services\InquiryService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

#[Layout('components.layouts.dashboard')]
class ManageInquiries extends Component
{
    use WithPagination;
    use WireToast;

    public string $search = '';
    public string $filterStatus = 'new'; // Default to 'new' inquiries
    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 10;

    protected $queryString = ['search', 'filterStatus', 'sortBy', 'sortDirection'];

    protected InquiryService $inquiryService;
    protected SearchInquiriesQuery $searchInquiriesQuery;

    public function boot(InquiryService $inquiryService, SearchInquiriesQuery $searchInquiriesQuery): void
    {
        $this->inquiryService = $inquiryService;
        $this->searchInquiriesQuery = $searchInquiriesQuery;
    }

    public function deleteInquiry(PackageInquiry $inquiry): void
    {
        $this->authorize('delete', $inquiry);

        $this->inquiryService->delete($inquiry);
        toast()->success('Inquiry berhasil dihapus.')->push();
    }

    public function updateStatus(PackageInquiry $inquiry, string $status): void
    {
        $this->authorize('update', $inquiry);

        $statusEnum = InquiryStatus::from($status);
        $this->inquiryService->updateStatus($inquiry, $statusEnum);
        toast()->success('Status inquiry berhasil diperbarui.')->push();
    }

    public function updated($propertyName): void
    {
        if (in_array($propertyName, ['search', 'filterStatus', 'sortBy', 'sortDirection', 'perPage'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $this->authorize('viewAny', PackageInquiry::class);

        $filters = [
            'search' => $this->search,
            'status' => $this->filterStatus,
            'sortBy' => $this->sortBy,
            'sortDirection' => $this->sortDirection,
        ];

        $inquiries = $this->searchInquiriesQuery->get($filters, $this->perPage);

        return view('livewire.admin.inquiries.manage-inquiries', [
            'inquiries' => $inquiries,
        ]);
    }
}
