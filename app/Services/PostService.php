<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostService
{
    public function create(array $data, ?UploadedFile $thumbnailFile): Post
    {
        return DB::transaction(function () use ($data, $thumbnailFile) {
            $data['slug'] = $this->generateUniqueSlug($data['title']);
            $data['author_id'] = Auth::id();

            if ($thumbnailFile) {
                $data['thumbnail'] = $thumbnailFile->store('posts/thumbnails', 'public');
            }

            return Post::create($data);
        });
    }

    public function update(Post $post, array $data, ?UploadedFile $thumbnailFile): Post
    {
        return DB::transaction(function () use ($post, $data, $thumbnailFile) {
            if ($post->title !== $data['title']) {
                $data['slug'] = $this->generateUniqueSlug($data['title'], $post->id);
            }

            if ($thumbnailFile) {
                // Delete old thumbnail if it exists
                if ($post->thumbnail) {
                    Storage::disk('public')->delete($post->thumbnail);
                }
                $data['thumbnail'] = $thumbnailFile->store('posts/thumbnails', 'public');
            }

            $post->update($data);

            return $post;
        });
    }

    public function delete(Post $post): bool
    {
        // Delete thumbnail from storage before deleting the post
        if ($post->thumbnail) {
            Storage::disk('public')->delete($post->thumbnail);
        }
        return $post->delete();
    }

    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (Post::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}
