@extends('layouts.app')
@section('title', 'Bantuan — B’cake')

@push('head')
    <style>
        .help-grid {
            --help-wine: #57091d;
            --help-berry: #890524;
        }

        .help-card {
            background: linear-gradient(135deg, #fde3ea 0%, #ffd6e6 100%);
            border-radius: 1.25rem;
            border: 1px solid rgba(137, 5, 36, 0.15);
            box-shadow: 0 10px 35px rgba(137, 5, 36, 0.12);
            padding: 1.6rem !important;
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .help-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 40px rgba(137, 5, 36, 0.22);
        }

        .help-card h2 {
            color: var(--help-wine);
            font-size: 1.1rem;
            margin-bottom: .3rem;
        }

        .help-card p,
        .help-card li {
            font-size: .92rem;
            line-height: 1.45rem;
        }

        .help-card ul li::marker {
            color: var(--help-berry);
        }
    </style>
@endpush

@section('content')
    <section class="space-y-6 help-grid">

        {{-- TOMBOL KEMBALI --}}
        <div>
            <a href="javascript:history.back()"
                class="inline-flex items-center gap-2 px-5 py-2 rounded-full 
          bg-rose-200 text-bcake-wine font-medium 
          shadow-md hover:bg-rose-300 hover:shadow-lg transition">
                ← Kembali
            </a>

        </div>

        <h1 class="font-display text-3xl">Bantuan</h1>

        {{-- GRID CARD --}}
        <div class="grid gap-6 md:grid-cols-2">

            {{-- Cara memesan --}}
            <div class="help-card">
                <h2>Cara memesan</h2>
                <ul class="list-disc pl-5 mt-2 space-y-1">
                    <li>Buka halaman <a href="{{ route('products.index') }}" class="text-bcake-wine underline">Produk</a> atau
                        Toko.</li>
                    <li>Pilih produk kue yang ingin dipesan.</li>
                    <li>Klik <strong>“Tambah ke Keranjang”</strong>.</li>
                    <li>Buka halaman <strong>Keranjang</strong> untuk cek ulang.</li>
                    <li>Klik <strong>“Checkout / Lanjut ke WhatsApp”</strong>.</li>
                    <li>Kamu akan diarahkan ke WhatsApp penjual.</li>
                </ul>
            </div>

            {{-- Pembayaran --}}
            <div class="help-card">
                <h2>Pembayaran</h2>
                <ul class="list-disc pl-5 mt-2 space-y-1">
                    <li>Transaksi dilakukan langsung antara pembeli & penjual.</li>
                    <li>Metode pembayaran ditentukan oleh penjual.</li>
                    <li>Pastikan nominal benar sebelum transfer.</li>
                    <li>Simpan bukti pembayaran & chat WA.</li>
                </ul>
            </div>

            {{-- Peran Bcake --}}
            <div class="help-card">
                <h2>Peran B’cake</h2>
                <ul class="list-disc pl-5 mt-2 space-y-1">
                    <li>B’cake hanya platform penghubung.</li>
                    <li>Tidak menyimpan saldo atau dana.</li>
                    <li>Harga & pengiriman diatur seller.</li>
                </ul>
            </div>

            {{-- Tips aman --}}
            <div class="help-card">
                <h2>Tips aman bertransaksi</h2>
                <ul class="list-disc pl-5 mt-2 space-y-1">
                    <li>Cocokkan nomor WA penjual.</li>
                    <li>Konfirmasi alamat & jadwal kirim.</li>
                    <li>Gunakan metode pembayaran aman.</li>
                    <li>Simpan bukti percakapan.</li>
                </ul>
            </div>

            {{-- FAQ --}}
            <div class="help-card md:col-span-2">
                <h2>FAQ (Pertanyaan Umum)</h2>
                <div class="mt-2 space-y-2">
                    <p><strong>Apakah B’cake menerima pembayaran?</strong><br>
                        Tidak, semua pembayaran dilakukan langsung ke penjual.</p>

                    <p><strong>Apakah harga final?</strong><br>
                        Harga final dikonfirmasi via WhatsApp seller.</p>

                    <p><strong>Jika ada masalah?</strong><br>
                        Hubungi seller melalui WhatsApp.</p>
                </div>
            </div>

        </div>

    </section>
@endsection
