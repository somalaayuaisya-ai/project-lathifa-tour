@props(['packages'])

<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50/50 text-xs uppercase text-gray-500 font-bold tracking-wider">
                {{ $head }}
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm">
            {{ $body }}
        </tbody>
    </table>
</div>

@if ($packages->hasPages())
<div class="px-6 py-4 border-t border-gray-100">
    {{ $packages->links() }}
</div>
@endif
