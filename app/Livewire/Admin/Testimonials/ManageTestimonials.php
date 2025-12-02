<?php

namespace App\Livewire\Admin\Testimonials;

use App\Models\Testimonial;
use App\Queries\SearchTestimonialsQuery;
use App\Services\TestimonialService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

#[Layout('components.layouts.dashboard')]
class ManageTestimonials extends Component
{
    use WithPagination;
    use WireToast;

    public string $search = '';
    public string $filterStatus = ''; // 'true' for show, 'false' for hidden

    protected $queryString = ['search', 'filterStatus'];

    #[On('testimonial-saved')]
    public function onTestimonialSaved(): void
    {
        toast()->success('Testimoni berhasil disimpan.')->push();
    }

    public function deleteTestimonial(Testimonial $testimonial, TestimonialService $testimonialService): void
    {
        $this->authorize('delete', $testimonial);
        $testimonialService->delete($testimonial);
        toast()->success('Testimoni berhasil dihapus.')->push();
    }

    public function toggleShow(Testimonial $testimonial, TestimonialService $testimonialService): void
    {
        $this->authorize('update', $testimonial);
        $testimonialService->toggleShow($testimonial);
        toast()->success('Status testimoni berhasil diubah.')->push();
    }

    public function render(SearchTestimonialsQuery $searchTestimonialsQuery)
    {
        $this->authorize('viewAny', Testimonial::class);

        $filters = [
            'search' => $this->search,
            'status' => $this->filterStatus,
        ];

        $testimonials = $searchTestimonialsQuery->get($filters);

        return view('livewire.admin.testimonials.manage-testimonials', [
            'testimonials' => $testimonials
        ]);
    }
}
