@props([
'disabled' => false,
'rows' => 4,
])

<textarea rows="{{ $rows }}" {{ $disabled ? 'disabled class=opacity-50 cursor-not-allowed' : '' }} {!! $attributes->merge([
        'class' =>
            'w-full px-4 py-3 text-base border border-gray-300 rounded-2xl
             bg-white shadow-sm transition-all outline-none
             focus:border-primary-500 focus:ring-2 focus:ring-primary-300
             placeholder-gray-400
             mt-1 block'
    ]) !!}
></textarea>
