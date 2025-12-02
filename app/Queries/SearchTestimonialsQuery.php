<?php

namespace App\Queries;

use App\Models\Testimonial;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class SearchTestimonialsQuery
{
    public function get(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return Testimonial::query()
            ->with('user')
            ->when(isset($filters['search']) && $filters['search'], function (Builder $query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('content', 'like', '%' . $filters['search'] . '%');
            })
            ->when(isset($filters['status']) && $filters['status'] !== '', function (Builder $query) use ($filters) {
                $query->where('is_show', (bool) $filters['status']);
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }
}
