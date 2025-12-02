<?php

namespace App\Queries;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class SearchPostsQuery
{
    public function get(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return Post::query()
            ->with('author') // Eager load author relationship
            ->when(isset($filters['search']) && $filters['search'], function (Builder $query) use ($filters) {
                $query->where('title', 'like', '%' . $filters['search'] . '%');
            })
            ->when(isset($filters['status']) && $filters['status'], function (Builder $query) use ($filters) {
                $query->where('status', $filters['status']);
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
