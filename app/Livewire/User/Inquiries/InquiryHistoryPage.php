<?php

namespace App\Livewire\User\Inquiries;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PackageInquiry;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class InquiryHistoryPage extends Component
{
    use WithPagination;
    #[Layout('components.layouts.dashboard')]
    public function render()
    {
        $inquiries = PackageInquiry::with('package') // Eager load relasi package
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('livewire.user.inquiries.inquiry-history-page', [
            'inquiries' => $inquiries
        ]);
    }
}
