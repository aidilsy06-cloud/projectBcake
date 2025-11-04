@props(['product'])
<a href="{{ route('products.show', $product->slug) }}" class="card overflow-hidden group">
  <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
       class="h-48 w-full object-cover group-hover:scale-[1.02] transition">
  <div class="p-4">
    <div class="flex items-start justify-between gap-3">
      <h3 class="font-semibold">{{ $product->name }}</h3>
      <span class="chip">Stok: {{ $product->stock }}</span>
    </div>
    <div class="mt-3 text-bcake-wine font-semibold">
      Rp {{ number_format($product->price,0,',','.') }}
    </div>
  </div>
</a>
