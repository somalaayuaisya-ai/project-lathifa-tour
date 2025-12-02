<?php

namespace App\Services;

use App\Models\Package;
use App\Models\PackageInquiry;
use App\Models\User;
use App\Queries\InquiryTrendQuery;
use Illuminate\Support\Facades\Cache;

class DashboardService
{
    /**
     * Get all essential data for the admin dashboard.
     * Caches the results to improve performance.
     *
     * @param string $chartPeriod
     * @return array
     */
    public function getDashboardData(string $chartPeriod = '7d'): array
    {
        return [
            'stats' => $this->getStats(),
            'inquiryChartData' => (new InquiryTrendQuery())->get($chartPeriod),
            'recentInquiries' => $this->getRecentInquiries(),
        ];
    }

    /**
     * Get the four main statistics for the stat cards.
     *
     * @return array
     */
    public function getStats(): array
    {
        return [
            'total_inquiries' => PackageInquiry::count(),
            'new_inquiries' => PackageInquiry::where('status', 'new')->count(),
            'active_packages' => Package::where('is_active', true)->count(),
            'total_users' => User::where('role', 'user')->count(),
        ];
    }

    /**
     * Get the 5 most recent new inquiries.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentInquiries()
    {
        return PackageInquiry::with('package')
            ->where('status', 'new')
            ->latest()
            ->take(5)
            ->get();
    }
}
