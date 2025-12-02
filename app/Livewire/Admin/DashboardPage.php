<?php

namespace App\Livewire\Admin;

use App\Services\DashboardService;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')] 
class DashboardPage extends Component
{
    public array $stats = [];
    public array $inquiryChartData = [];
    public $recentInquiries;
    public string $chartFilter = '7d';

    protected DashboardService $dashboardService;

    public function boot(DashboardService $dashboardService): void
    {
        $this->dashboardService = $dashboardService;
    }

    public function mount(): void
    {
        $this->loadDashboardData();
    }

    public function updatedChartFilter(): void
    {
        $this->inquiryChartData = $this->dashboardService->getDashboardData($this->chartFilter)['inquiryChartData'];
        $this->dispatch('chart-data-updated', data: $this->inquiryChartData);
    }
    
    public function refreshStats(): void
    {
        $this->stats = $this->dashboardService->getStats();
    }

    private function loadDashboardData(): void
    {
        $data = $this->dashboardService->getDashboardData($this->chartFilter);
        $this->stats = $data['stats'];
        $this->inquiryChartData = $data['inquiryChartData'];
        $this->recentInquiries = $data['recentInquiries'];
    }

    public function render()
    {
        return view('livewire.admin.dashboard-page');
    }
}
