<?php

namespace App\Livewire\Admin\Testimonials;

use App\Models\Testimonial;
use App\Models\User;
use App\Services\TestimonialService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class TestimonialFormModal extends Component
{
    use WithFileUploads;

    public bool $modalOpen = false;
    public ?Testimonial $testimonial = null;
    public ?int $testimonialId = null;

    // Form fields
    public ?int $user_id = null;
    public string $name = '';
    public string $job_title = '';
    public string $content = '';
    public int $rating = 5;
    public bool $is_show = true;
    public $avatarUpload = null; // For new avatar upload

    // Properties for user search
    public string $userSearch = '';
    public $users = [];
    public ?string $selectedUserName = null;

    protected function rules(): array {
        return [
            'user_id' => ['nullable', 'exists:users,id'],
            'name' => ['required_if:user_id,null', 'string', 'max:255'], // Required only if no user selected
            'job_title' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:1000'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'is_show' => ['boolean'],
            'avatarUpload' => ['nullable', 'image', 'max:2048'], // 2MB Max
        ];
    }

    // --- User Search Logic ---
    public function updatedUserSearch($value): void
    {
        if (empty($value) && $this->user_id !== null) {
            $this->user_id = null;
            $this->selectedUserName = null;
            $this->users = [];
            return;
        }
        
        if (empty($value) || strlen($value) < 2) {
            $this->users = [];
            return;
        }
        
        if ($this->selectedUserName === $value && $this->user_id !== null) {
            $this->users = [];
            return;
        }

        $this->users = User::where(function ($query) use ($value) {
                $query->where('name', 'like', '%' . $value . '%')
                      ->orWhere('email', 'like', '%' . $value . '%');
            })
            ->take(5)
            ->get();
    }

    public function selectUser(User $user): void
    {
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->selectedUserName = $user->name;
        $this->userSearch = $user->name;
        $this->users = [];
    }

    #[On('open-testimonial-form')]
    public function openModal(?int $testimonialId = null): void
    {
        $this->resetForm();
        if ($testimonialId) {
            $this->testimonial = Testimonial::with('user')->findOrFail($testimonialId);
            $this->fillForm($this->testimonial);
        }
        $this->modalOpen = true;
    }

    public function save(TestimonialService $testimonialService): void
    {
        $validatedData = $this->validate();

        $data = [
            'user_id' => $this->user_id,
            'name' => $this->name,
            'job_title' => $this->job_title,
            'content' => $this->content,
            'rating' => $this->rating,
            'is_show' => $this->is_show,
        ];

        if ($this->testimonial) {
            $testimonialService->update($this->testimonial, $data, $this->avatarUpload);
        } else {
            $testimonialService->create($data, $this->avatarUpload);
        }
        $this->dispatch('testimonial-saved');
        $this->closeModal();
    }

    public function closeModal(): void { $this->modalOpen = false; }

    protected function fillForm(Testimonial $testimonial): void 
    {
        $this->testimonialId = $testimonial->id;
        $this->fill($testimonial->only(['user_id', 'name', 'job_title', 'content', 'rating', 'is_show']));
        
        if ($testimonial->user) {
            $this->selectedUserName = $testimonial->user->name;
            $this->userSearch = $testimonial->user->name;
        } else {
            $this->userSearch = $testimonial->name;
        }
    }
    protected function resetForm(): void 
    {
        $this->reset();
        $this->testimonial = null;
        $this->testimonialId = null;
    }

    public function render()
    {
        return view('livewire.admin.testimonials.testimonial-form-modal');
    }
}