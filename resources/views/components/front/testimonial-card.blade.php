@props(['testimonial'])

<div class="bg-sand p-8 rounded-2xl relative">
    <div class="text-gold-400 text-4xl font-serif absolute top-4 left-4">“</div>
    <p class="text-gray-600 italic mb-6 relative z-10">{{ $testimonial['content'] }}</p>
    <div class="flex items-center gap-4">
        <img src="{{ $testimonial['avatar_url'] }}" alt="{{ $testimonial['name'] }}" class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm">
        <div>
            <h4 class="font-bold text-gray-900 text-sm">{{ $testimonial['name'] }}</h4>
            <p class="text-xs text-gray-500">{{ $testimonial['job_title'] }}</p>
        </div>
        <div class="ml-auto flex text-gold-400 text-xs">
            @for ($i = 0; $i < $testimonial['rating']; $i++)
                <span>★</span>
            @endfor
        </div>
    </div>
</div>
