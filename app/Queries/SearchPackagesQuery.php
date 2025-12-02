<?php

namespace App\Queries;

use App\Models\Package;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class SearchPackagesQuery
{
    public function get(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return Package::query()
            ->when(isset($filters['search']) && $filters['search'], function (Builder $query) use ($filters) {
                $search = $filters['search'];
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('hotel_makkah', 'like', '%' . $search . '%')
                    ->orWhere('hotel_madinah', 'like', '%' . $search . '%')
                    ->orWhere('airline_name', 'like', '%' . $search . '%');
            })
            ->when(isset($filters['status']) && $filters['status'] !== '', function (Builder $query) use ($filters) {
                $query->where('is_active', (bool) $filters['status']);
            })
            ->when(isset($filters['sortBy']) && $filters['sortBy'], function (Builder $query) use ($filters) {
                $query->orderBy($filters['sortBy'], $filters['sortDirection'] ?? 'asc');
            }, function (Builder $query) {
                $query->latest('departure_date'); // Default sort
            })
            ->paginate($perPage)
            ->withQueryString();
    }
}
