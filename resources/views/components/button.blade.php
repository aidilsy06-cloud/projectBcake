@props(['as' => 'a', 'href' => '#'])
<{{ $as }} {{ $attributes->merge([
    'href' => $as==='a' ? $href : null,
    'class' =>
      'inline-flex items-center justify-center px-5 py-3 rounded-xl2 shadow-soft
       bg-bcake-cherry text-white font-medium tracking-wide
       hover:bg-bcake-wine focus:outline-none focus:ring-2 focus:ring-bcake-icing/60
       transition'
  ]) }}>
  {{ $slot }}
</{{ $as }}>
