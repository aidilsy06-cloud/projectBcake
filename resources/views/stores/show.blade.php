@extends('layouts.app')

@section('title', $store->name . ' — B’cake')

@section('content')

<div class="mb-4 inline-flex">
    <a href="{{ route('buyer.stores.index') }}"
       class="px-3 py-1.5 rounded-full bg-rose-100 text-bcake-wine text-xs hover:bg-rose-200 transition">
        ← Kembali ke toko
    </a>
</div>

{{-- ===================== HEADER TOKO ===================== --}}
<section class="mb-8">
    <div class="relative h-56 rounded-2xl overflow-hidden shadow-soft">
        <img src="{{ $store->banner_url ?? 'https://via.placeholder.com/1200x400?text=Banner+Toko' }}"
             class="w-full h-full object-cover">
    </div>

    <div class="flex items-center gap-4 mt-4">
        <img src="{{ $store->logo_url ?? 'https://via.placeholder.com/120.png?text=Logo' }}"
             class="h-20 w-20 rounded-xl object-cover border border-rose-200 shadow-soft">

        <div>
            <h1 class="text-3xl font-display text-bcake-wine">{{ $store->name }}</h1>
            <p class="text-gray-600 text-sm">
                {{ $store->description ?? 'Toko ini belum menambahkan deskripsi.' }}
            </p>

            <div class="mt-2 flex items-center gap-3 text-sm text-rose-600">
                <span>📍 {{ $store->address ?? 'Alamat belum tersedia' }}</span>
            </div>

            {{-- Tentukan nomor WhatsApp toko --}}
            @php
                $waNumber = null;

                if (!empty($store->whatsapp)) {
                    // ambil dari kolom `whatsapp` di tabel stores
                    $raw = preg_replace('/\D+/', '', $store->whatsapp); // hanya angka

                    // kalau format 08xxxx → ubah ke 62xxxx
                    if (substr($raw, 0, 1) === '0') {
                        $raw = '62' . substr($raw, 1);
                    }

                    $waNumber = $raw;
                }
            @endphp

            {{-- Tombol WhatsApp / info jika belum diatur --}}
            <div class="mt-3">
                @if($waNumber)
                    <a href="https://wa.me/{{ $waNumber }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 px-4 py-1.5 text-sm bg-emerald-600 text-white rounded-full hover:bg-emerald-700">
                        <span>Chat Penjual</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-3-3v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </a>
                @else
                    <p class="text-xs text-rose-500">
                        Toko belum mengatur nomor WhatsApp.
                    </p>
                @endif
            </div>
        </div>
    </div>
</section>



{{-- ===================== FORM PEMESANAN ===================== --}}
<section class="bg-white border border-rose-200/40 rounded-2xl p-6 mb-12 shadow-soft">
    <h2 class="text-xl font-semibold text-bcake-bitter mb-3">Pesan Langsung dari Toko</h2>
    <p class="text-gray-600 text-sm mb-4">
        Isi data berikut untuk melakukan pemesanan. Setelah submit, kamu akan diarahkan ke WhatsApp penjual 💗
    </p>

    {{-- pakai route ke OrderController@store --}}
    <form action="{{ route('stores.order', $store) }}" method="POST" class="space-y-4">
        @csrf

        {{-- Nama --}}
        <div>
            <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
            <input type="text" name="customer_name"
                   value="{{ old('customer_name', auth()->user()->name ?? '') }}"
                   required
                   class="w-full rounded-xl border border-rose-200 px-4 py-2 focus:ring-rose-300 focus:border-rose-300">
        </div>

        {{-- Nomor HP --}}
        <div>
            <label class="block text-sm font-medium mb-1">Nomor WhatsApp</label>
            <input type="text" name="customer_phone"
                   value="{{ old('customer_phone') }}"
                   placeholder="08xxxx"
                   required
                   class="w-full rounded-xl border border-rose-200 px-4 py-2 focus:ring-rose-300 focus:border-rose-300">
        </div>

        {{-- Alamat --}}
        <div>
            <label class="block text-sm font-medium mb-1">Alamat (Opsional)</label>
            <textarea name="customer_address" rows="2"
                      class="w-full rounded-xl border border-rose-200 px-4 py-2 focus:ring-rose-300 focus:border-rose-300"
                      placeholder="Tulis alamat lengkap jika perlu pengantaran">{{ old('customer_address') }}</textarea>
        </div>

        {{-- Ringkasan Pesanan --}}
        <div>
            <label class="block text-sm font-medium mb-1">Ringkasan Pesanan</label>
            <textarea name="order_summary" rows="2"
                      required
                      class="w-full rounded-xl border border-rose-200 px-4 py-2 focus:ring-rose-300 focus:border-rose-300"
                      placeholder="Contoh: 1x Red Velvet ukuran M, 2x Cupcake Cokelat">{{ old('order_summary') }}</textarea>
        </div>

        {{-- Catatan --}}
        <div>
            <label class="block text-sm font-medium mb-1">Catatan Tambahan (Opsional)</label>
            <textarea name="note" rows="2"
                      class="w-full rounded-xl border border-rose-200 px-4 py-2 focus:ring-rose-300 focus:border-rose-300"
                      placeholder="Contoh: tanpa kacang, diambil jam 3 sore, dll">{{ old('note') }}</textarea>
        </div>

        <button type="submit"
                class="px-5 py-2.5 rounded-full bg-emerald-600 text-white hover:bg-emerald-700 inline-flex items-center gap-2">
            <span>Kirim ke WhatsApp Penjual</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 12h14m-7-7l7 7-7 7"/>
            </svg>
        </button>
    </form>
</section>



{{-- ===================== PRODUK TOKO ===================== --}}
<section>
    <h2 class="text-xl font-semibold text-bcake-bitter mb-4">Produk dari {{ $store->name }}</h2>

    @if($products->count() == 0)
        <p class="text-gray-500 text-sm">Toko ini belum menambahkan produk.</p>
    @else
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <a href="{{ route('products.show', $product->slug) }}"
                   class="block bg-white rounded-2xl border border-rose-200 overflow-hidden shadow-soft hover:shadow-lg transition">
                    <img src="{{ $product->image_url ?? 'https://via.placeholder.com/400' }}"
                         class="w-full h-52 object-cover">

                    <div class="p-4">
                        <h3 class="font-medium text-bcake-bitter">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>

                        <span class="text-xs text-white bg-bcake-wine px-2 py-1 rounded-full mt-2 inline-block">
                            {{ $product->category->name ?? 'Kategori' }}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</section>

@endsection
