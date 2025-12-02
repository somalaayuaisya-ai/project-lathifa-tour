<div class="flex flex-col sm:flex-row items-center justify-between mb-6 gap-4">
    <div class="flex-1 w-full sm:w-auto">
        {{ $search ?? '' }}
    </div>
    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto items-center">
        {{ $filters ?? '' }}
        {{ $sort ?? '' }}
        {{ $actions ?? '' }}
    </div>
</div>
