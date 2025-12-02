<?php

namespace App\Livewire\Admin\Packages;

use App\Models\Package;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Services\PackageService;
use Illuminate\Support\Facades\Storage;

class PackageFormModal extends Component
{
    use WithFileUploads;

    public bool $modalOpen = false;
    public ?Package $package = null;
    public ?int $packageId = null;
    public int $currentStep = 1;

    // Step 1 Fields
    public string $title = '';
    public string $slug = '';
    public $price_quad = 0;
    public $price_triple = 0;
    public $price_double = 0;
    public string $departure_date = '';
    public int $duration_days = 9;
    public string $hotel_makkah = '';
    public string $hotel_madinah = '';
    public string $airline_name = '';
    public string $description = '';
    public bool $is_featured = false;
    public bool $is_active = true;
    public $featuredImageUpload = null;

    // Step 2 & 3 Fields
    public array $itineraries = [];
    public array $galleries = [];
    public array $galleryUploads = [];

    protected function stepOneRules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('packages', 'slug')->ignore($this->packageId)],
            'price_quad' => ['required', 'numeric', 'min:0'],
            'departure_date' => ['required', 'date'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'hotel_makkah' => ['nullable', 'string', 'max:255'],
            'hotel_madinah' => ['nullable', 'string', 'max:255'],
            'airline_name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'featuredImageUpload' => ['nullable', 'image', 'max:2048'],
        ];
    }
    protected function stepTwoRules(): array
    {
        return [
            'itineraries' => ['array', 'min:1'],
            'itineraries.*.day_number' => ['required', 'integer'],
            'itineraries.*.title' => ['required', 'string', 'max:255'],
            'itineraries.*.description' => ['required', 'string'],
        ];
    }
    protected function stepThreeRules(): array
    {
        return [
            'galleries' => ['array'],
            'galleryUploads.*' => ['image', 'max:2048'],
        ];
    }

    #[On('open-package-form')]
    public function openModal(?int $packageId = null): void
    {
        $this->resetForm();
        if ($packageId) {
            $this->package = Package::with(['itineraries', 'galleries'])->findOrFail($packageId);
            $this->fillForm($this->package);
        } else {
            $this->addItineraryDay();
        }
        $this->modalOpen = true;
    }

    public function nextStep(): void
    {
        if ($this->currentStep === 1) $this->validate($this->stepOneRules());
        if ($this->currentStep === 2) $this->validate($this->stepTwoRules());

        if ($this->currentStep < 3) $this->currentStep++;
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) $this->currentStep--;
    }

    public function save(PackageService $packageService): void
    {
        $validatedData = $this->validate(array_merge($this->stepOneRules(), $this->stepTwoRules(), $this->stepThreeRules()));

        $mainData = collect($validatedData)->only(array_keys($this->stepOneRules()))->except('featuredImageUpload')->all();

        if ($this->package) {
            $packageService->update($this->package, $mainData, $this->itineraries, $this->featuredImageUpload, $this->galleryUploads);
        } else {
            $packageService->create($mainData, $this->itineraries, $this->featuredImageUpload, $this->galleryUploads);
        }
        $this->dispatch('package-saved');
        $this->closeModal();
    }

    public function addItineraryDay(): void
    {
        $this->itineraries[] = ['day_number' => count($this->itineraries) + 1, 'title' => '', 'description' => ''];
    }
    public function removeItineraryDay(int $index): void
    {
        unset($this->itineraries[$index]);
        $this->itineraries = array_values($this->itineraries);
    }
    public function addGalleryItem(): void
    {
        $this->galleryUploads[] = null;
    }
    public function removeGalleryItem(int $index): void
    {
        if (isset($this->galleries[$index]['id'])) {
            $gallery = \App\Models\PackageGallery::find($this->galleries[$index]['id']);
            if ($gallery) {
                Storage::disk('public')->delete($gallery->image_url);
                $gallery->delete();
            }
        }
        unset($this->galleries[$index]);
        $this->galleries = array_values($this->galleries);
    }
    public function removeNewGalleryItem(int $index): void
    {
        unset($this->galleryUploads[$index]);
        $this->galleryUploads = array_values($this->galleryUploads);
    }

    public function updatedTitle($value): void
    {
        if (is_null($this->packageId)) $this->slug = Str::slug($value);
    }
    public function closeModal(): void
    {
        $this->modalOpen = false;
    }

    protected function fillForm(Package $package): void
    {
        $this->packageId = $package->id;
        $this->fill($package->only(['title', 'slug', 'price_quad', 'price_triple', 'price_double', 'duration_days', 'hotel_makkah', 'hotel_madinah', 'airline_name', 'description', 'is_featured', 'is_active']));
        $this->departure_date = $package->departure_date->format('Y-m-d');
        $this->itineraries = $package->itineraries->toArray();
        $this->galleries = $package->galleries->toArray();
    }
    protected function resetForm(): void
    {
        $this->reset();
        $this->itineraries = [];
        $this->galleries = [];
        $this->galleryUploads = [];
        $this->currentStep = 1;
    }

    public function render()
    {
        return view('livewire.admin.packages.package-form-modal');
    }
}
