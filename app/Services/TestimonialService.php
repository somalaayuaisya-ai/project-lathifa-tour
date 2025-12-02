<?php

namespace App\Services;

use App\Models\Testimonial;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TestimonialService
{
    public function create(array $data, ?UploadedFile $avatarFile): Testimonial
    {
        return DB::transaction(function () use ($data, $avatarFile) {
            if ($avatarFile) {
                $data['avatar_url'] = $avatarFile->store('testimonials/avatars', 'public');
            } else {
                // If no file uploaded, generate a default avatar based on name
                $name = $data['name'] ?? 'Guest';
                $data['avatar_url'] = 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=f59e0b&color=fff';
            }
            return Testimonial::create($data);
        });
    }

    public function update(Testimonial $testimonial, array $data, ?UploadedFile $avatarFile): Testimonial
    {
        return DB::transaction(function () use ($testimonial, $data, $avatarFile) {
            if ($avatarFile) {
                // Delete old avatar if it exists and is not a generated ui-avatar
                if ($testimonial->avatar_url && !Str::contains($testimonial->avatar_url, 'ui-avatars.com')) {
                    Storage::disk('public')->delete($testimonial->avatar_url);
                }
                $data['avatar_url'] = $avatarFile->store('testimonials/avatars', 'public');
            } elseif ($testimonial->avatar_url && isset($data['avatar_url']) && is_null($data['avatar_url']) && !Str::contains($testimonial->avatar_url, 'ui-avatars.com')) {
                // If existing avatar is cleared and it's not a generated ui-avatar, delete it.
                Storage::disk('public')->delete($testimonial->avatar_url);
                $data['avatar_url'] = null;
            } else {
                 // Retain old avatar_url if no new file and no explicit clear (and not a generated ui-avatar)
                 if (!isset($data['avatar_url'])) { // Only if avatar_url is not being explicitly set to null
                    unset($data['avatar_url']);
                 }
            }

            $testimonial->update($data);
            return $testimonial;
        });
    }

    public function delete(Testimonial $testimonial): bool
    {
        if ($testimonial->avatar_url && !Str::contains($testimonial->avatar_url, 'ui-avatars.com')) {
            Storage::disk('public')->delete($testimonial->avatar_url);
        }
        return $testimonial->delete();
    }

    public function toggleShow(Testimonial $testimonial): Testimonial
    {
        $testimonial->is_show = !$testimonial->is_show;
        $testimonial->save();
        return $testimonial;
    }
}
