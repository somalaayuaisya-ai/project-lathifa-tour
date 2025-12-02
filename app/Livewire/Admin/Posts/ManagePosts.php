<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use App\Queries\SearchPostsQuery;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

#[Layout('components.layouts.dashboard')]
class ManagePosts extends Component
{
    use WithPagination;
    use WireToast;

    public string $search = '';
    public string $filterStatus = ''; // 'published', 'draft'
    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';

    protected $queryString = ['search', 'filterStatus', 'sortBy', 'sortDirection'];

    #[On('post-saved')]
    public function postSaved(): void
    {
        toast()->success('Artikel berhasil disimpan.')->push();
        $this->resetPage();
    }

    public function deletePost(Post $post): void
    {
        $this->authorize('delete', $post);
        $post->delete();
        toast()->success('Artikel berhasil dihapus.')->push();
    }
    
    public function render(SearchPostsQuery $searchPostsQuery)
    {
        $this->authorize('viewAny', Post::class);

        $filters = [
            'search' => $this->search,
            'status' => $this->filterStatus,
            'sortBy' => $this->sortBy,
            'sortDirection' => $this->sortDirection,
        ];

        $posts = $searchPostsQuery->get($filters);

        return view('livewire.admin.posts.manage-posts', [
            'posts' => $posts
        ]);
    }
}
