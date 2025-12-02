@props(['chartData'])

<div
    wire:ignore
    x-data="chartComponent({ initialData: {{ json_encode($chartData) }} })"
    x-init="initChart()"
    @chart-data-updated.window="updateChart($event.detail.data)"
>
    <div x-ref="chart"></div>
</div>
