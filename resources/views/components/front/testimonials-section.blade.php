@props(['testimonials' => []])

<section class="bg-white py-20 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="section-title">Kata Jamaah</h2>
            <div class="section-divider"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($testimonials as $testimonial)
                <x-front.testimonial-card :testimonial="$testimonial" />
            @endforeach
        </div>
    </div>
</section>
