@extends('layouts.app')

@section('title','Bantuan — B’cake')

@push('head')
<style>
  :root{
    --bcake-wine:#890524;
    --bcake-deep:#57091d;
    --bcake-cocoa:#362320;
  }
  .page-bg{
    background:
      radial-gradient(900px 500px at 5% -10%, #ffe6eb 0%, transparent 60%),
      radial-gradient(900px 500px at 95% -10%, #ffeef2 0%, transparent 60%),
      #fff7f8;
  }
  .bg-bcake-grad{
    background: linear-gradient(135deg, var(--bcake-deep) 0%, var(--bcake-wine) 55%, var(--bcake-cocoa) 100%);
  }
  .card-soft{
    background: linear-gradient(145deg, #fff, #fff6f7 60%, #ffecef 100%);
  }
  .shadow-soft{box-shadow:0 18px 40px rgba(54,35,32,.10)}
  .ring-soft{box-shadow:inset 0 0 0 1px rgba(244, 63, 94, .25)}
</style>
@endpush

@section('content')
<div class="page-bg">
  <div class="max-w-6xl mx-auto px-4 lg:px-8 py-10 space-y-8">

    {{-- HERO bantuan --}}
    <header class="rounded-3xl bg-bcake-grad text-white p-8 shadow-soft">
      <div class="grid md:grid-cols-2 gap-6 items-center">
        <div>
          <h1 class="text-3xl md:text-4xl font-semibold">Butuh Bantuan? 🍰</h1>
          <p class="mt-2 text-white/90">Kami siap bantu soal pesanan, pembayaran, akun, atau pengiriman.</p>
          <div class="mt-5 flex flex-wrap gap-3">
            <a href="#faq" class="inline-flex items-center gap-2 bg-white text-[var(--bcake-wine)] px-4 py-2 rounded-xl font-medium">Lihat FAQ →</a>
            <a href="#kontak" class="inline-flex items-center gap-2 bg-white/10 backdrop-blur px-4 py-2 rounded-xl ring-1 ring-white/30">Hubungi Kami</a>
          </div>
        </div>
        <div class="hidden md:block rounded-2xl overflow-hidden ring-1 ring-white/20">
          <img src="{{ asset('image/cake.jpg') }}" alt="" class="w-full h-full object-cover">
        </div>
      </div>
    </header>

    <div class="grid lg:grid-cols-3 gap-8">

      {{-- Kolom kiri: FAQ --}}
      <section id="faq" class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-soft ring-soft p-6">
          <h2 class="text-lg font-semibold">Pesanan & Katalog</h2>
          <div class="mt-3 divide-y">
            <details class="group py-3">
              <summary class="flex items-center justify-between cursor-pointer">
                <span>Bagaimana cara memesan produk?</span>
                <span class="text-rose-600">＋</span>
              </summary>
              <div class="mt-2 text-gray-600">
                Buka menu <b>Produk</b> → pilih produk → klik <b>Tambah ke Keranjang</b> → buka <b>Keranjang</b> → <b>Checkout</b>.
              </div>
            </details>

            <details class="group py-3">
              <summary class="flex items-center justify-between cursor-pointer">
                <span>Apakah bisa custom tulisan pada kue?</span>
                <span class="text-rose-600">＋</span>
              </summary>
              <div class="mt-2 text-gray-600">
                Bisa. Tulis permintaan di catatan saat checkout. Untuk desain khusus, chat WhatsApp kami dulu.
              </div>
            </details>
          </div>
        </div>

        <div class="bg-white rounded-2xl shadow-soft ring-soft p-6">
          <h2 class="text-lg font-semibold">Pembayaran</h2>
          <div class="mt-3 divide-y">
            <details class="group py-3">
              <summary class="flex items-center justify-between cursor-pointer">
                <span>Metode pembayaran apa saja yang tersedia?</span>
                <span class="text-rose-600">＋</span>
              </summary>
              <div class="mt-2 text-gray-600">
                Transfer bank, e-wallet (OVO/DANA/GoPay), dan COD (khusus area tertentu).
              </div>
            </details>

            <details class="group py-3">
              <summary class="flex items-center justify-between cursor-pointer">
                <span>Mengunggah bukti bayar bagaimana?</span>
                <span class="text-rose-600">＋</span>
              </summary>
              <div class="mt-2 text-gray-600">
                Setelah checkout, unggah bukti pada halaman <b>Pesanan</b> atau kirim via WhatsApp ke admin.
              </div>
            </details>
          </div>
        </div>

        <div class="bg-white rounded-2xl shadow-soft ring-soft p-6">
          <h2 class="text-lg font-semibold">Akun & Keamanan</h2>
          <div class="mt-3 divide-y">
            <details class="group py-3">
              <summary class="flex items-center justify-between cursor-pointer">
                <span>Lupa password, bagaimana reset?</span>
                <span class="text-rose-600">＋</span>
              </summary>
              <div class="mt-2 text-gray-600">
                Di halaman <b>Login</b> klik <b>Forgot password?</b>, masukkan email, lalu ikuti instruksi yang dikirim.
              </div>
            </details>

            <details class="group py-3">
              <summary class="flex items-center justify-between cursor-pointer">
                <span>Bagaimana menjaga keamanan akun?</span>
                <span class="text-rose-600">＋</span>
              </summary>
              <div class="mt-2 text-gray-600">
                Gunakan password kuat, jangan bagikan OTP, dan selalu logout dari perangkat umum.
              </div>
            </details>
          </div>
        </div>

        <div class="bg-white rounded-2xl shadow-soft ring-soft p-6">
          <h2 class="text-lg font-semibold">Pengiriman</h2>
          <div class="mt-3 divide-y">
            <details class="group py-3">
              <summary class="flex items-center justify-between cursor-pointer">
                <span>Berapa lama pengiriman?</span>
                <span class="text-rose-600">＋</span>
              </summary>
              <div class="mt-2 text-gray-600">
                Same-day untuk area kota; 1–2 hari untuk sekitar; pre-order kue custom menyesuaikan jadwal produksi.
              </div>
            </details>

            <details class="group py-3">
              <summary class="flex items-center justify-between cursor-pointer">
                <span>Produk saya rusak saat sampai, apa yang harus saya lakukan?</span>
                <span class="text-rose-600">＋</span>
              </summary>
              <div class="mt-2 text-gray-600">
                Foto kondisi paket maksimal 24 jam, lalu hubungi kami melalui WhatsApp untuk penggantian/solusi terbaik.
              </div>
            </details>
          </div>
        </div>
      </section>

      {{-- Kolom kanan: Kontak & Form --}}
      <aside id="kontak" class="space-y-6">
        <div class="card-soft rounded-2xl p-6 shadow-soft ring-soft">
          <h3 class="font-semibold">Hubungi Kami</h3>
          <p class="text-sm text-gray-600 mt-1">Pilih salah satu jalur dukungan:</p>

          <div class="mt-4 grid gap-3">
            <a href="https://wa.me/6281234567890?text=Halo%20B%E2%80%99cake%2C%20saya%20butuh%20bantuan%20soal%20pesanan."
               class="flex items-center justify-between rounded-xl px-4 py-3 bg-white ring-1 ring-rose-200/60 hover:bg-rose-50">
              <span>💬 WhatsApp Admin</span>
              <span class="text-rose-700 text-sm">Buka WA →</span>
            </a>

            <a href="mailto:support@bcake.local?subject=Butuh%20Bantuan&body=Halo%20B%E2%80%99cake..."
               class="flex items-center justify-between rounded-xl px-4 py-3 bg-white ring-1 ring-rose-200/60 hover:bg-rose-50">
              <span>✉️ Email Support</span>
              <span class="text-rose-700 text-sm">Tulis Email →</span>
            </a>

            <a href="https://instagram.com/" target="_blank"
               class="flex items-center justify-between rounded-xl px-4 py-3 bg-white ring-1 ring-rose-200/60 hover:bg-rose-50">
              <span>📷 DM Instagram</span>
              <span class="text-rose-700 text-sm">Kunjungi IG →</span>
            </a>
          </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-soft ring-soft">
          <h3 class="font-semibold">Kirim Pertanyaan</h3>
          <p class="text-sm text-gray-600">Form ini tidak menyimpan ke server (aman di halaman statis) — klik kirim akan membuka WhatsApp dengan isi pesan kamu.</p>

          <form class="mt-4 space-y-3" onsubmit="openWA(this); return false;">
            <div>
              <label class="text-sm text-gray-700">Nama</label>
              <input class="mt-1 w-full rounded-xl border-rose-200 px-3 h-10" name="nama" required>
            </div>
            <div>
              <label class="text-sm text-gray-700">Email (opsional)</label>
              <input class="mt-1 w-full rounded-xl border-rose-200 px-3 h-10" name="email" type="email">
            </div>
            <div>
              <label class="text-sm text-gray-700">Pesan</label>
              <textarea class="mt-1 w-full rounded-xl border-rose-200 px-3 py-2 min-h-[100px]" name="pesan" required placeholder="Tulis pertanyaanmu…"></textarea>
            </div>
            <button class="w-full bg-bcake-grad text-white rounded-xl h-11 shadow-soft">Kirim via WhatsApp</button>
          </form>
          <script>
            function openWA(form){
              const q = new URLSearchParams({
                text:
`Halo B’cake, saya ${form.nama.value}.
Email: ${form.email.value || '-'}
Pesan: ${form.pesan.value}`
              }).toString();
              // ganti nomor WA admin di bawah ini
              const wa = '6281234567890';
              window.open(`https://wa.me/${wa}?${q}`,'_blank');
            }
          </script>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-soft ring-soft">
          <h3 class="font-semibold">Cek Status Pesanan</h3>
          <p class="text-sm text-gray-600">Masukkan kode pesanan (mis. BC-2025-001):</p>
          <div class="mt-3 flex gap-2">
            <input id="ordcode" class="flex-1 rounded-xl border-rose-200 px-3 h-10" placeholder="BC-XXXX-XXX">
            <button class="rounded-xl h-10 px-4 bg-rose-100 text-rose-700" onclick="alert('Fitur cek status akan terhubung ke halaman pesanan.');">Cek</button>
          </div>
          <p class="text-xs text-gray-500 mt-2">Catatan: tombol ini contoh. Nanti bisa diarahkan ke halaman /orders.</p>
        </div>
      </aside>
    </div>

  </div>
</div>
@endsection
