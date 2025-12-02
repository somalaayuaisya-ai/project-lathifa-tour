<?php

namespace App\Queries;

use App\Models\PackageInquiry;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class SearchInquiriesQuery
{
    public function get(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return PackageInquiry::query()
            ->with(['package', 'user']) // Eager load relations
            ->when(isset($filters['search']) && $filters['search'], function (Builder $query) use ($filters) {
                $search = $filters['search'];
                $query->where(function (Builder $subQuery) use ($search) {
                    $subQuery->where('guest_name', 'like', '%' . $search . '%')
                        ->orWhere('guest_phone', 'like', '%' . $search . '%')
                        ->orWhereHas('user', function (Builder $userQuery) use ($search) {
                            $userQuery->where('name', 'like', '%' . $search . '%')
                                      ->orWhere('email', 'like', '%' . $search . '%');
                        });
                });
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
