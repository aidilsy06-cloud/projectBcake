@props(['count' => 0])

<a href="{{ route('cart.index') }}"
   class="inline-flex items-center gap-2 rounded-full bg-white/95 px-3 py-2 shadow-md ring-1 ring-black/5 hover:bg-white transition"
   aria-label="Buka keranjang ({{ $count }})">
    {{-- Ikon troli (SVG kecil) --}}
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
         class="h-4 w-4">
        <path fill="currentColor"
              d="M7 18a2 2 0 1 0 0 4a2 2 0 0 0 0-4m10 0a2 2 0 1 0 0 4a2 2 0 0 0 0-4M6.2 4H4V2h3.1c.46 0 .86.31.98.75L8.5 6H20a1 1 0 0 1 .97 1.24l-1.7 7a2 2 0 0 1-1.94 1.51H9a2 2 0 0 1-1.94-1.51L5.16 5.24A1 1 0 0 0 4.2 4zM9 13h8.2l1.2-5H8.07z"/>
    </svg>

    {{-- Angka --}}
    <span class="text-base font-medium tabular-nums">
        {{ $count }}
    </span>
</a>
