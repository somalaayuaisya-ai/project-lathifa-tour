<?php

namespace App\Livewire\Admin\Posts;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Services\PostService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads; // Import the trait

#[Layout('components.layouts.dashboard')]
class PostForm extends Component
{
    use WithFileUploads; // Use the trait

    public Post $post;

    // Form fields
    public string $title = '';
    public string $content = '';
    public string $status = 'published';
    public $thumbnailUpload = null; // Property for the file upload

    public function mount(?Post $post = null): void
    {
        $this->post = $post ?? new Post();
        $this->fillForm();
    }
    
    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'status' => ['required', Rule::in(array_column(PostStatus::cases(), 'value'))],
            'thumbnailUpload' => ['nullable', 'image', 'max:2048'], // 2MB Max
        ];
    }
    
    public function save(PostService $postService)
    {
        $validatedData = $this->validate();

        // Prepare data for the service, excluding the temporary upload property
        $postData = [
            'title' => $this->title,
            'content' => $this->content,
            'status' => $this->status,
        ];

        if ($this->post->exists) {
            $this->authorize('update', $this->post);
            $postService->update($this->post, $postData, $this->thumbnailUpload);
        } else {
            $this->authorize('create', Post::class);
            $postService->create($postData, $this->thumbnailUpload);
        }

        $this->dispatch('post-saved');
        return redirect()->route('admin.posts.index');
    }
    
    protected function fillForm(): void
    {
        $this->title = $this->post->title ?? '';
        $this->content = $this->post->content ?? '';
        $this->status = $this->post->status->value ?? 'published';
        $this->thumbnailUpload = null; // Reset file input on each load
    }

    public function render()
    {
        return view('livewire.admin.posts.post-form');
    }
}
