@php
  // ambil produk terbaru atau placeholder
  $cards = ($latestProducts ?? collect())->count()
    ? $latestProducts
    : collect($placeholders ?? []);
@endphp

<div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
  @foreach($cards as $p)
    @php
      // aman untuk object & array
      $name  = is_array($p) ? ($p['name'] ?? 'Produk') : ($p->name ?? 'Produk');
      $price = is_array($p) ? ($p['price'] ?? 0) : ($p->price ?? 0);
      $img   = is_array($p)
        ? ($p['img'] ?? 'https://placehold.co/640x400')
        : ($p->image_url ?? $p->cover_url ?? 'https://placehold.co/640x400');
      $url   = is_array($p) ? ($p['url'] ?? '#') : '#';
    @endphp

    <article class="soft-card overflow-hidden group">
      <a href="{{ $url }}">
        <img src="{{ $img }}" alt="{{ $name }}"
             class="h-44 w-full object-cover group-hover:scale-[1.03] transition">
      </a>
      <div class="p-4">
        <h3 class="font-medium line-clamp-1">{{ $name }}</h3>
        <div class="mt-2 flex items-center justify-between">
          <span class="font-semibold text-[var(--deep)]">
            Rp{{ number_format($price,0,',','.') }}
          </span>
          <a href="{{ $url }}" class="chip text-xs">Lihat Detail</a>
        </div>
      </div>
    </article>
  @endforeach
</div>
