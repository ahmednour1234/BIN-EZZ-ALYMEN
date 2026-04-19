@props(['variant' => 'primary', 'size' => 'md', 'href' => null])

@php
    $base = 'inline-flex items-center justify-center gap-2 font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2';

    $variants = match($variant) {
        'primary' => 'bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-400 shadow-sm',
        'secondary' => 'bg-white text-primary-700 border border-primary-300 hover:bg-primary-50 focus:ring-primary-300',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-400 shadow-sm',
        'success' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-400 shadow-sm',
        'ghost' => 'text-gray-600 hover:bg-gray-100 focus:ring-gray-300',
        default => 'bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-400 shadow-sm',
    };

    $sizes = match($size) {
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
        default => 'px-4 py-2.5 text-sm',
    };

    $classes = "$base $variants $sizes";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes, 'type' => 'button']) }}>
        {{ $slot }}
    </button>
@endif
