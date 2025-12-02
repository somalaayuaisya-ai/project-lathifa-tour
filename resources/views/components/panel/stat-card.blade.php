@props([
    'title',
    'value',
    'icon',
    'iconStyle' => null,
    'trend' => null,
    'trendColor' => null,
    'iconColorClass' => 'bg-gray-50 text-gray-600',
])

<div class="bg-white p-5 rounded-2xl shadow-soft border border-gray-100 flex items-center justify-between hover:shadow-md transition-shadow">
    <div>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $title }}</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $value }}</p>
        @if($trend)
            @php
                $trendColorClass = [
                    'green' => 'text-green-500',
                    'red' => 'text-red-500',
                ][$trendColor] ?? 'text-gray-500';
            @endphp
            <p class="text-xs mt-1 flex items-center gap-1 {{ $trendColorClass }}">
                @if($trendColor)
                    <x-dynamic-component :component="'phosphor-trend-'.($trendColor === 'green' ? 'up' : 'down').'-bold'" class="w-4 h-4" />
                @endif
                {{ $trend }}
            </p>
        @endif
    </div>
    <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $iconColorClass }}">
        <x-dynamic-component :component="'phosphor-'.$icon.($iconStyle ? '-'.$iconStyle : '')" class="w-6 h-6" />
    </div>
</div>
