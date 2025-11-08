@extends('layouts.app')
@section('title','Bantuan — B’cake')

@push('head')
<style>
/* ===== THEME (pakai palet B’cake) ===== */
:root{
  --icing:#d0d1c9; --icing-2:#e6e7e3;
  --truffle:#6a4e4a; --truffle-2:#c7c2bf;
  --wine:#890524; --deep:#57091d; --cocoa:#362320; --rose:#fff1f2;
}
.cherry{color:var(--wine)} .deep{color:var(--deep)}
.btn-wine{background:var(--wine);color:#fff} .btn-wine:hover{background:var(--deep)}
.bcake-border{border-color:color-mix(in oklab,var(--wine),white 72%)}
.bcake-shadow{box-shadow:0 14px 40px rgba(54,35,32,.12)}
.glass{background:rgba(255,255,255,.78);backdrop-filter:blur(10px)}
details .chev{transition:transform .2s ease} details[open] .chev{transform:rotate(180deg)}
details[open] .acc-body{animation:fade .25s ease}
@keyframes fade{from{opacity:0;transform:translateY(-4px)}to{opacity:1;transform:translateY(0)}}
/* Floating widget */
#help-widget{position:fixed;right:18px;bottom:18px;z-index:60}
.widget-card{width:320px;max-width:92vw}
/* Simple star rating */
.star{font-size:22px;cursor:pointer;opacity:.55} .star.active{opacity:1}
</style>
@endpush

@section('content')
{{-- ===== HERO ===== --}}
<section class="relative">
  <div class="absolute inset-0 bg-gradient-to-b from-rose-50 to-rose-100/60"></div>
  <div class="relative max-w-6xl mx-auto px-5 md:px-8 py-14">
    <div class="grid md:grid-cols-2 gap-8 items-center">
      <div>
        <h1 class="font-display text-4xl md:text-5xl cherry">Bantuan & Panduan Belanja</h1>
        <p class="mt-3 text-[color:var(--truffle)]">
          Semua jawaban tentang pemesanan, pembayaran, dan pengiriman. Kalau masih bingung, tinggal chat kami ya! 🍒
        </p>

        {{-- Quick Actions --}}
        <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-3">
          <a href="{{ route('products.index') }}" class="glass bcake-shadow border bcake-border rounded-2xl p-4 text-center hover:-translate-y-0.5 transition">
            <div class="text-2xl">🛍️</div><div class="text-sm mt-1 font-medium">Katalog</div>
          </a>
          <a href="{{ route('cart.index') }}" class="glass bcake-shadow border bcake-border rounded-2xl p-4 text-center hover:-translate-y-0.5 transition">
            <div class="text-2xl">🧺</div><div class="text-sm mt-1 font-medium">Keranjang</div>
          </a>
          <a href="#kebijakan" class="glass bcake-shadow border bcake-border rounded-2xl p-4 text-center hover:-translate-y-0.5 transition">
            <div class="text-2xl">📜</div><div class="text-sm mt-1 font-medium">Kebijakan</div>
          </a>
          <a href="https://wa.me/6281234567890" target="_blank" class="glass bcake-shadow border bcake-border rounded-2xl p-4 text-center hover:-translate-y-0.5 transition">
            <div class="text-2xl">💬</div><div class="text-sm mt-1 font-medium">WhatsApp</div>
          </a>
        </div>
      </div>

      {{-- Search FAQ --}}
      <div class="glass bcake-shadow border bcake-border rounded-2xl p-5">
        <label class="text-sm text-[color:var(--truffle)]">Cari topik bantuan</label>
        <div class="mt-2 flex items-center gap-3 border bcake-border rounded-xl px-3 py-2 bg-white">
          <svg class="w-5 h-5 cherry" viewBox="0 0 24 24" fill="currentColor"><path d="M10 2a8 8 0 105.293 14.293l4.707 4.707 1.414-1.414-4.707-4.707A8 8 0 0010 2zm0 2a6 6 0 110 12A6 6 0 0110 4z"/></svg>
          <input id="faqSearch" type="text" placeholder="cth: pembayaran, pengiriman..."
                 class="w-full outline-none py-2" />
        </div>
        <p class="text-xs mt-2 text-[color:var(--truffle)]/80">Hasil akan memfilter daftar FAQ di bawah secara realtime.</p>
      </div>
    </div>
  </div>
</section>

<div class="max-w-6xl mx-auto px-5 md:px-8 space-y-10 -mt-6 pb-16">

  {{-- ===== TIMELINE ===== --}}
  <section class="glass bcake-shadow border bcake-border rounded-2xl p-6 md:p-8">
    <h2 class="font-semibold text-xl cherry mb-5 flex items-center gap-2">🛒 Cara Memesan</h2>
    <ol class="relative border-s ps-6 space-y-6 border-[color:var(--truffle-2)]/70">
      <li class="relative">
        <span class="absolute -start-3 top-0 w-6 h-6 rounded-full bg-[color:var(--wine)] ring-4 ring-rose-50"></span>
        <p class="font-medium">Buka <a href="{{ route('products.index') }}" class="underline cherry">katalog</a> dan pilih produk favoritmu.</p>
      </li>
      <li class="relative">
        <span class="absolute -start-3 top-0 w-6 h-6 rounded-full bg-[color:var(--wine)] ring-4 ring-rose-50"></span>
        <p class="font-medium">Klik <em>Tambah ke Keranjang</em> → cek <a href="{{ route('cart.index') }}" class="underline cherry">Keranjang</a>.</p>
      </li>
      <li class="relative">
        <span class="absolute -start-3 top-0 w-6 h-6 rounded-full bg-[color:var(--wine)] ring-4 ring-rose-50"></span>
        <p class="font-medium">Isi alamat & catatan (tulisan kue, lilin, dll), lalu pilih metode pembayaran.</p>
      </li>
      <li class="relative">
        <span class="absolute -start-3 top-0 w-6 h-6 rounded-full bg-[color:var(--wine)] ring-4 ring-rose-50"></span>
        <p class="font-medium">Upload bukti bayar. Kami proses & update via WhatsApp. 🎉</p>
      </li>
    </ol>

    {{-- Mini tracker (dummy) --}}
    <form class="mt-6 grid sm:grid-cols-3 gap-3" onsubmit="event.preventDefault();alert('Tracking contoh: #BC-001 sedang dikemas 🎁');">
      <input class="border bcake-border rounded-xl px-4 py-3" placeholder="Masukkan Kode Pesanan (cth: BC-001)">
      <button class="btn-wine rounded-xl px-5 py-3">Lacak Pesanan</button>
      <a href="{{ route('cart.index') }}" class="rounded-xl px-5 py-3 border bcake-border text-center hover:bg-rose-50">Lihat Riwayat</a>
    </form>
  </section>

  {{-- ===== FAQ / ACCORDION ===== --}}
  @php
    $faqs = [
      ['t'=>'Metode Pembayaran','b'=>'Transfer bank & e-wallet (DANA/OVO/Gopay). Pastikan nominal tepat agar verifikasi cepat.'],
      ['t'=>'Pengiriman','b'=>'Kurir instan / local courier. Estimasi 30–90 menit area kota (tergantung cuaca & antrian).'],
      ['t'=>'Jam Operasional','b'=>'08:00 – 21:00 WIB setiap hari. Balasan chat ± 1–10 menit saat jam aktif.'],
      ['t'=>'Custom & Pre-Order','b'=>'Bisa tulis ucapan dan request warna sederhana. Untuk desain khusus disarankan PO H-1 s/d H-3.'],
      ['t'=>'Alergen','b'=>'Produk dapat mengandung gluten, susu, telur. Mohon info alergi saat checkout.'],
      ['t'=>'Penyimpanan','b'=>'Kue cream: suhu kulkas 2–3 hari. Brownies/cookies: suhu ruang kedap 3–5 hari.'],
      ['t'=>'Batal & Refund','b'=>'Bisa batal maksimal 30 menit setelah order. Jika produk rusak saat antar, hubungi admin (foto/video) untuk solusi.'],
      ['t'=>'Area Jangkauan','b'=>'Bengkalis, Dumai, Rupat & sekitar. Ongkir mengikuti aplikasi kurir/driver.'],
      ['t'=>'COD','b'=>'Saat ini belum tersedia COD. Gunakan transfer bank/e-wallet.'],
      ['t'=>'Resi / Bukti Antar','b'=>'Driver akan mengirimkan foto serah-terima ke WhatsApp penerima.'],
    ];
  @endphp

  <section>
    <h2 class="font-semibold text-xl cherry mb-4 flex items-center gap-2">❓ Pertanyaan Umum</h2>
    <div id="faqList" class="grid md:grid-cols-2 gap-5">
      @foreach($faqs as $f)
      <details class="group glass bcake-shadow border bcake-border rounded-2xl p-5">
        <summary class="flex items-center justify-between cursor-pointer font-semibold cherry">
          <span class="faq-title">{{ $f['t'] }}</span>
          <svg class="chev w-5 h-5 cherry" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd"/></svg>
        </summary>
        <div class="acc-body text-[color:var(--truffle)] leading-relaxed mt-3 faq-body">
          {{ $f['b'] }}
        </div>
      </details>
      @endforeach
    </div>
  </section>

  {{-- ===== POLICY & TIPS ===== --}}
  <section id="kebijakan" class="grid lg:grid-cols-3 gap-6">
    <div class="glass bcake-shadow border bcake-border rounded-2xl p-6">
      <h3 class="font-semibold cherry text-lg">📜 Kebijakan Singkat</h3>
      <ul class="mt-3 text-[color:var(--truffle)] space-y-2">
        <li>• Cancel max 30 menit setelah order.</li>
        <li>• Salah alamat/jam terima di luar tanggung jawab kami.</li>
        <li>• Komplain produk max 6 jam setelah diterima (sertakan bukti).</li>
      </ul>
    </div>
    <div class="glass bcake-shadow border bcake-border rounded-2xl p-6">
      <h3 class="font-semibold cherry text-lg">🥛 Alergen & Nutrisi</h3>
      <p class="mt-2 text-[color:var(--truffle)]">Mengandung gluten, susu, telur. Bebas pengawet; sebaiknya dikonsumsi fresh.</p>
      <div class="mt-3 flex flex-wrap gap-2 text-xs">
        <span class="px-3 py-1 rounded-full border bcake-border bg-white">Gluten</span>
        <span class="px-3 py-1 rounded-full border bcake-border bg-white">Dairy</span>
        <span class="px-3 py-1 rounded-full border bcake-border bg-white">Egg</span>
      </div>
    </div>
    <div class="glass bcake-shadow border bcake-border rounded-2xl p-6">
      <h3 class="font-semibold cherry text-lg">📦 Tips Penyimpanan</h3>
      <ul class="mt-3 text-[color:var(--truffle)] space-y-2">
        <li>• Simpan cake ber-cream dalam box tertutup di kulkas.</li>
        <li>• Keluarkan 10–15 menit sebelum disajikan.</li>
        <li>• Hindari paparan panas langsung saat pengantaran.</li>
      </ul>
    </div>
  </section>

  {{-- ===== CONTACT / CTA ===== --}}
  <section class="glass bcake-shadow border bcake-border rounded-2xl p-6 md:p-8">
    <div class="grid md:grid-cols-2 gap-6 items-center">
      <div>
        <h3 class="font-semibold text-2xl cherry">Masih butuh bantuan?</h3>
        <p class="mt-2 text-[color:var(--truffle)]">Tim B’cake siap membantu. Chat admin untuk rekomendasi produk, cek ketersediaan, atau masalah pesanan.</p>
        <div class="mt-5 flex gap-3 flex-wrap">
          <a href="https://wa.me/6281234567890" target="_blank" class="btn-wine rounded-xl px-5 py-3 bcake-shadow">Chat WhatsApp</a>
          <a href="mailto:cs@bcake.id" class="rounded-xl px-5 py-3 border bcake-border hover:bg-rose-50">Email cs@bcake.id</a>
        </div>
      </div>
      <div class="border bcake-border rounded-2xl p-4 bg-white">
        <div class="text-sm text-[color:var(--truffle)] mb-2">Nilai pengalamanmu hari ini:</div>
        <div id="rating" class="flex gap-2">
          <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
        </div>
        <textarea id="fb" class="mt-3 w-full border bcake-border rounded-xl p-3" rows="3" placeholder="Tulis saran singkat…"></textarea>
        <button onclick="sendFeedback()" class="btn-wine rounded-xl px-4 py-2 mt-3">Kirim</button>
        <p id="fbMsg" class="text-sm mt-2 text-green-700 hidden">Terima kasih! Feedback kamu tersimpan 🙌</p>
      </div>
    </div>
  </section>
</div>

{{-- ===== FLOATING HELP WIDGET ===== --}}
<div id="help-widget">
  <button id="helpBtn" class="btn-wine rounded-full w-14 h-14 bcake-shadow text-2xl">?</button>
  <div id="helpCard" class="hidden widget-card mt-3 glass bcake-shadow border bcake-border rounded-2xl p-4">
    <div class="flex items-center justify-between">
      <div class="font-semibold cherry">Butuh cepat?</div>
      <button onclick="toggleHelp()" class="text-xl">✕</button>
    </div>
    <div class="mt-3 grid gap-2 text-sm">
      <a href="{{ route('products.index') }}" class="underline cherry">Lihat Katalog</a>
      <a href="#kebijakan" class="underline cherry">Baca Kebijakan</a>
      <a href="https://wa.me/6281234567890" target="_blank" class="underline cherry">Chat WhatsApp</a>
    </div>
  </div>
</div>

{{-- ===== SEO: FAQ Schema ===== --}}
<script type="application/ld+json">
{
 "@context":"https://schema.org","@type":"FAQPage",
 "mainEntity":[
  @foreach($faqs as $i=>$f){"@type":"Question","name":"{{ $f['t'] }}",
   "acceptedAnswer":{"@type":"Answer","text":"{{ $f['b'] }}"} }@if(!$loop->last),@endif
  @endforeach
 ]
}
</script>

{{-- ===== Tiny JS (tanpa library) ===== --}}
<script>
// Toggle floating widget
function toggleHelp(){ document.getElementById('helpCard').classList.toggle('hidden'); }
document.getElementById('helpBtn').addEventListener('click',toggleHelp);

// FAQ live search
const s = document.getElementById('faqSearch');
const items = Array.from(document.querySelectorAll('#faqList details'));
s.addEventListener('input', () => {
  const q = s.value.toLowerCase();
  items.forEach(d => {
    const t = d.querySelector('.faq-title').textContent.toLowerCase();
    const b = d.querySelector('.faq-body').textContent.toLowerCase();
    d.style.display = (t.includes(q) || b.includes(q)) ? '' : 'none';
  });
});

// Rating simple
let score = Number(localStorage.getItem('bcake_rate')||0);
const stars = Array.from(document.querySelectorAll('#rating .star'));
const paint = (n)=>stars.forEach((el,i)=>el.classList.toggle('active',i<n));
paint(score);
stars.forEach((el,i)=>el.onclick=()=>{score=i+1; localStorage.setItem('bcake_rate',score); paint(score);});

function sendFeedback(){
  const txt = document.getElementById('fb').value.trim();
  // di real-app bisa POST ke route khusus. Ini dummy local:
  localStorage.setItem('bcake_feedback', JSON.stringify({score, txt, at: new Date().toISOString()}));
  document.getElementById('fbMsg').classList.remove('hidden');
}
</script>
@endsection
