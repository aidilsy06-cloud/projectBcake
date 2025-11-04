<aside class="lg:sticky lg:top-24 space-y-4">
  <div class="rounded-xl2 border border-bcake-truffle/15 bg-white shadow-soft">
    <div class="px-4 py-3 text-xs font-semibold tracking-wider text-bcake-truffle/70 uppercase">
      Navigasi
    </div>
    <nav class="px-2 pb-2">
      <a href="{{ route('about') }}"
         class="block px-3 py-2 rounded-lg transition
           {{ request()->routeIs('about')
                ? 'bg-bcake-icing/80 text-bcake-bitter font-medium'
                : 'hover:bg-bcake-icing/50 text-bcake-truffle' }}">
        Tentang Kami
      </a>
      <a href="{{ route('help') }}"
         class="block px-3 py-2 rounded-lg transition
           {{ request()->routeIs('help')
                ? 'bg-bcake-icing/80 text-bcake-bitter font-medium'
                : 'hover:bg-bcake-icing/50 text-bcake-truffle' }}">
        Bantuan
      </a>
    </nav>
  </div>

  {{-- Kartu kecil opsional --}}
  <div class="rounded-xl2 border border-bcake-truffle/15 bg-white p-4 shadow-soft">
    <div class="text-sm text-bcake-truffle">
      Butuh bantuan cepat? DM kami via Instagram <span class="font-medium text-bcake-wine">@bcake.id</span>
    </div>
  </div>
</aside>
