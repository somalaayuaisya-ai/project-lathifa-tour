@props(['disabled' => false, 'withIcon' => false])

@php
$withIconClasses = $withIcon ? 'pl-12' : '';
@endphp

<input {{ $disabled ? 'disabled class=opacity-50 cursor-not-allowed' : '' }} {!! $attributes->merge([
'class' =>
'w-full h-12 px-4 text-base border border-gray-300 rounded-2xl
bg-white shadow-sm transition-all outline-none
focus:border-primary-500 focus:ring-2 focus:ring-primary-300
placeholder-gray-400 ' . $withIconClasses
]) !!}
>
