@props([
    'type' => 'button',
    'href' => null,
    'variant' => 'primary',
    'disabled' => false,
])

@php
$base = 'inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2';
$variants = [
    'primary' => 'text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
    'secondary' => 'text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-gray-500',
    'danger' => 'text-white bg-red-600 hover:bg-red-700 focus:ring-red-500',
];
$classes = trim($base . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($attributes->get('class') ?? ''));
@endphp

@if($href)
    <a {{ $attributes->merge(['href' => $href, 'class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button
        {{ $attributes->merge(['type' => $type, 'class' => $classes]) }}
        @if($disabled) disabled @endif
    >
        {{ $slot }}
    </button>
@endif
