@props([
  'count' => 0,     // jumlah item
  'href'  => route('cart.index'),
])

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 rounded-full bg-white px-3 py-2 shadow-md ring-1 ring-black/5 hover:bg-white/95 transition']) }}
   aria-label="Buka keranjang ({{ (int)$count }})">

  {{-- ===== Ikon Keranjang Lucu (SVG) ===== --}}
  <svg class="h-5 w-5" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <defs>
      <linearGradient id="cartBody" x1="0" y1="0" x2="1" y2="1">
        <stop offset="0%"  stop-color="#FF9FB3"/>
        <stop offset="100%" stop-color="#D2335B"/>
      </linearGradient>
      <linearGradient id="wheel" x1="0" y1="0" x2="1" y2="1">
        <stop offset="0%"  stop-color="#FFE4EA"/>
        <stop offset="100%" stop-color="#C5B7BE"/>
      </linearGradient>
    </defs>

    <!-- keranjang -->
    <rect x="7" y="14" rx="4" ry="4" width="38" height="8" fill="url(#cartBody)"/>
    <path d="M10 20h34l-2.5 15a4 4 0 0 1-3.9 3.3H18.4a4 4 0 0 1-3.9-3.2L10 20Z"
          fill="url(#cartBody)" opacity=".95"/>
    <!-- garis-garis manis -->
    <path d="M16 23h22M15 28h24M14 33h26" stroke="white" stroke-opacity=".6" stroke-width="1.6" stroke-linecap="round"/>

    <!-- pegangan -->
    <path d="M13 14c0-3 2.5-5 5.5-5H28" stroke="#A30F33" stroke-width="2.5" stroke-linecap="round"/>

    <!-- shine -->
    <path d="M12 16c0 0 3-3 6-3" stroke="#FFDDE6" stroke-width="2" stroke-linecap="round" />

    <!-- roda -->
    <circle cx="19" cy="41" r="4.6" fill="url(#wheel)"/>
    <circle cx="36" cy="41" r="4.6" fill="url(#wheel)"/>
    <circle cx="19" cy="41" r="2.1" fill="#5B4E53"/>
    <circle cx="36" cy="41" r="2.1" fill="#5B4E53"/>

    <!-- spark kecil -->
    <circle cx="45" cy="13" r="1.3" fill="#FFDDE6"/>
    <circle cx="48" cy="16" r="1.6" fill="#FFBACB"/>
  </svg>

  {{-- angka --}}
  <span class="text-base font-medium tabular-nums">{{ (int)$count }}</span>

  {{-- badge merah kecil (hanya saat count > 0) --}}
  @if((int)$count > 0)
    <span class="ml-0.5 inline-flex h-4 min-w-4 items-center justify-center rounded-full bg-bcake-wine px-1 text-[10px] font-semibold text-white leading-none">
      {{ (int)$count }}
    </span>
  @endif
</a>
