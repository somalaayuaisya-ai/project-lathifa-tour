<?php

namespace App\Queries;

use App\Models\PackageInquiry;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InquiryTrendQuery
{
    /**
     * Get inquiry trend data formatted for ApexCharts.
     *
     * @param string $period ('7d', '30d', '1m')
     * @return array
     */
    public function get(string $period = '7d'): array
    {
        $endDate = Carbon::now()->endOfDay();
        $startDate = match ($period) {
            '30d' => Carbon::now()->subDays(29)->startOfDay(),
            '1m' => Carbon::now()->startOfMonth()->startOfDay(),
            default => Carbon::now()->subDays(6)->startOfDay(),
        };

        // Fetch data from DB
        $inquiries = PackageInquiry::query()
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->pluck('count', 'date');

        // Prepare a date range array with 0 counts
        $dateRange = collect(Carbon::parse($startDate)->toPeriod($endDate))->mapWithKeys(function (Carbon $date) {
            return [$date->format('Y-m-d') => 0];
        });

        // Merge DB data into the date range
        $data = $dateRange->merge($inquiries);

        // Format for ApexCharts
        return [
            'series' => [['name' => 'Inquiries Baru', 'data' => $data->values()->all()]],
            'categories' => $data->keys()->map(fn ($date) => Carbon::parse($date)->format('d M'))->all(),
        ];
    }
}
