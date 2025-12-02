@props(['packages', 'wishlistedPackageIds'])

<section id="packages" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="text-center mb-16">
        <h2 class="section-title">Paket Umroh Pilihan</h2>
        <div class="section-divider"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($packages as $package)
        <x-front.package-card :package="$package" :wishlistedPackageIds="$wishlistedPackageIds" />
        @endforeach
    </div>

    @if ($packages->hasPages())
    <div class="mt-12">
        {{ $packages->links() }}
    </div>
    @endif
</section>
