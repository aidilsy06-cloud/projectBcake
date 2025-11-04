@props([
    'as' => 'a',      // 'a' atau 'button'
    'href' => '#',    // hanya dipakai kalau <a>
    'variant' => 'primary', // primary | outline | ghost
    'disabled' => false,
])

@php
    $base = "inline-flex items-center justify-center px-5 py-3 rounded-xl2 font-medium tracking-wide
             shadow-soft transition focus:outline-none focus:ring-2 focus:ring-bcake-icing/60";

    $variants = [
        'primary' => "bg-bcake-cherry text-white hover:bg-bcake-wine",
        'outline' => "border border-bcake-truffle/40 text-bcake-bitter hover:border-bcake-cherry hover:text-bcake-cherry bg-white",
        'ghost'   => "text-bcake-bitter hover:text-bcake-cherry bg-transparent",
    ];

    $classes = $base . " " . ($variants[$variant] ?? $variants['primary']);

    if ($disabled) {
        $classes .= " opacity-50 cursor-not-allowed hover:none";
    }
@endphp

@if ($as === 'button')
    <button {{ $attributes->merge(['class' => $classes, 'disabled' => $disabled]) }}>
        {{ $slot }}
    </button>
@else
    <a {{ $attributes->merge(['href' => $href, 'class' => $classes]) }}>
        {{ $slot }}
    </a>
@endif
