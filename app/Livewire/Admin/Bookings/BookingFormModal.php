<?php

namespace App\Livewire\Admin\Bookings;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Package;
use App\Models\User;
use App\Services\BookingService;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Validation\Rule;

class BookingFormModal extends Component
{
    public bool $modalOpen = false;
    public ?Booking $booking = null;
    public ?int $bookingId = null;

    // Form fields
    public ?int $user_id = null;
    public ?int $package_id = null;
    public float $total_amount = 0;
    public string $status = 'pending_payment';
    public string $notes = '';

    // Properties for user search
    public string $userSearch = '';
    public $users = [];
    public ?string $selectedUserName = null;

    protected function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'package_id' => ['required', 'exists:packages,id'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(array_column(BookingStatus::cases(), 'value'))],
            'notes' => ['nullable', 'string', 'max:500'], // Added max length
        ];
    }

    public function updatedUserSearch($value): void
    {
        // If user clears the input after selection, unset user_id and related data
        if (empty($value) && $this->user_id !== null) {
            $this->user_id = null;
            $this->selectedUserName = null;
            $this->users = [];
            return;
        }
        
        // If the current search matches the selected user, don't show search results
        if ($this->selectedUserName === $value && $this->user_id !== null) {
            $this->users = [];
            return;
        }

        // Only search if input length is sufficient and it's not the selected user's name
        if (strlen($value) < 2) {
            $this->users = [];
            return;
        }

        $this->users = User::where('role', 'user') // Only search for 'user' role
            ->where(function ($query) use ($value) {
                $query->where('name', 'like', '%' . $value . '%')
                      ->orWhere('email', 'like', '%' . $value . '%');
            })
            ->take(5)
            ->get();
    }

    public function selectUser(User $user): void
    {
        $this->user_id = $user->id;
        $this->selectedUserName = $user->name;
        $this->userSearch = $user->name; // Fill the input with the selected user's name
        $this->users = []; // Clear search results after selection
    }

    public function updatedPackageId($value): void
    {
        // Auto-fill price from the selected package
        $package = Package::find($value);
        if ($package) {
            $this->total_amount = $package->price_quad; // Default to Quad price
        }
    }

    #[On('open-booking-form')]
    public function openModal(?int $bookingId = null): void
    {
        $this->resetValidation();
        $this->resetForm();
        
        $this->bookingId = $bookingId;
        if ($bookingId) {
            $this->booking = Booking::findOrFail($bookingId);
            $this->fillForm($this->booking);
        }

        $this->modalOpen = true;
    }

    public function save(BookingService $bookingService): void
    {
        $validatedData = $this->validate();

        if ($this->booking) {
            $bookingService->update($this->booking, $validatedData);
        } else {
            $bookingService->create($validatedData);
        }

        $this->dispatch('booking-saved');
        $this->closeModal();
    }
    
    public function closeModal(): void
    {
        $this->modalOpen = false;
    }

    protected function fillForm(Booking $booking): void
    {
        $this->user_id = $booking->user_id;
        $this->package_id = $booking->package_id;
        $this->total_amount = $booking->total_amount;
        $this->status = $booking->status->value;
        $this->notes = $booking->notes ?? '';
        
        $this->selectedUserName = $booking->user->name;
        $this->userSearch = $booking->user->name;
    }

    protected function resetForm(): void
    {
        $this->reset(['user_id', 'package_id', 'total_amount', 'status', 'notes', 'userSearch', 'users', 'selectedUserName', 'booking', 'bookingId']);
    }

    public function render()
    {
        return view('livewire.admin.bookings.booking-form-modal', [
            'allPackages' => Package::where('is_active', true)->orderBy('title')->get()
        ]);
    }
}
