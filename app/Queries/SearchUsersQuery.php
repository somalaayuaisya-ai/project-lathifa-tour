<?php

namespace App\Queries;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class SearchUsersQuery
{
    public function get(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return User::query()
            ->when(isset($filters['search']) && $filters['search'], function (Builder $query) use ($filters) {
                $search = $filters['search'];
                $query->where(function (Builder $subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%');
                });
            })
            ->when(isset($filters['role']) && $filters['role'], function (Builder $query) use ($filters) {
                $query->where('role', $filters['role']);
            })
            ->when(isset($filters['sortBy']) && $filters['sortBy'], function (Builder $query) use ($filters) {
                $query->orderBy($filters['sortBy'], $filters['sortDirection'] ?? 'asc');
            }, function (Builder $query) {
                $query->latest(); // Default sort by created_at desc
            })
            ->paginate($perPage)
            ->withQueryString();
    }
}
