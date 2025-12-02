<?php

namespace App\Services;

use App\Models\Package;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PackageService
{
    public function create(array $mainData, array $itinerariesData, ?UploadedFile $featuredImage, array $galleryUploads): Package
    {
        return DB::transaction(function () use ($mainData, $itinerariesData, $featuredImage, $galleryUploads) {
            $mainData['slug'] = Str::slug($mainData['title']);
            
            if ($featuredImage) {
                $mainData['featured_image'] = $featuredImage->store('packages/featured', 'public');
            }

            $package = Package::create($mainData);

            if (!empty($itinerariesData)) {
                $package->itineraries()->createMany($itinerariesData);
            }

            foreach ($galleryUploads as $file) {
                $path = $file->store('packages/galleries', 'public');
                $package->galleries()->create(['image_url' => $path]);
            }

            return $package;
        });
    }

    public function update(Package $package, array $mainData, array $itinerariesData, ?UploadedFile $featuredImage, array $galleryUploads): Package
    {
        return DB::transaction(function () use ($package, $mainData, $itinerariesData, $featuredImage, $galleryUploads) {
            if ($package->title !== $mainData['title']) {
                $mainData['slug'] = Str::slug($mainData['title']);
            }

            if ($featuredImage) {
                if ($package->featured_image) Storage::disk('public')->delete($package->featured_image);
                $mainData['featured_image'] = $featuredImage->store('packages/featured', 'public');
            }
            
            $package->update($mainData);

            // Sync Itineraries
            $package->itineraries()->delete();
            if (!empty($itinerariesData)) $package->itineraries()->createMany($itinerariesData);

            // Add new gallery images
            foreach ($galleryUploads as $file) {
                $path = $file->store('packages/galleries', 'public');
                $package->galleries()->create(['image_url' => $path]);
            }
            
            // Note: This logic doesn't handle deleting specific gallery images from the repeater yet.
            // A more complex implementation would track IDs. For now, we only add.

            return $package;
        });
    }

    public function delete(Package $package): bool
    {
        return DB::transaction(function() use ($package) {
            // Delete all associated gallery images
            foreach ($package->galleries as $gallery) {
                Storage::disk('public')->delete($gallery->image_url);
            }
            // Delete the featured image
            if ($package->featured_image) {
                Storage::disk('public')->delete($package->featured_image);
            }
            return $package->delete();
        });
    }

    public function toggleActive(Package $package): Package
    {
        $package->is_active = !$package->is_active;
        $package->save();
        return $package;
    }
}
