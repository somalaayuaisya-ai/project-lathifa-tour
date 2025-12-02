<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Queries\SearchUsersQuery;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

#[Layout('components.layouts.dashboard')]
class ManageUsers extends Component
{
    use WithPagination;
    use WireToast;

    public string $search = '';
    public string $filterRole = ''; // 'admin', 'user', '' for all
    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 10;

    protected $queryString = ['search', 'filterRole', 'sortBy', 'sortDirection'];

    #[On('user-saved')]
    public function userSaved(): void
    {
        $this->resetPage();
        toast()->success('Data pengguna berhasil disimpan.')->push();
    }

    public function deleteUser(User $user): void
    {
        $this->authorize('delete', $user);
        
        $user->delete();
        toast()->success('Pengguna berhasil dihapus.')->push();
    }
    
    public function updated($propertyName): void
    {
        if (in_array($propertyName, ['search', 'filterRole', 'perPage'])) {
            $this->resetPage();
        }
    }

    public function render(SearchUsersQuery $searchUsersQuery)
    {
        $this->authorize('viewAny', User::class);

        $filters = [
            'search' => $this->search,
            'role' => $this->filterRole,
            'sortBy' => $this->sortBy,
            'sortDirection' => $this->sortDirection,
        ];

        $users = $searchUsersQuery->get($filters, $this->perPage);
        
        return view('livewire.admin.users.manage-users', [
            'users' => $users,
        ]);
    }
}
