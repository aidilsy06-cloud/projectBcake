@extends('auth.layouts.base')

@section('title','Lupa Password — B’cake')

@section('content')
<div class="auth-card slide-in-right">

  <h2 class="title">Lupa Password?</h2>
  <p class="subtitle">Masukkan email Anda untuk menerima kode OTP.</p>

  @if (session('status'))
    <div class="alert success">{{ session('status') }}</div>
  @endif

  @error('email')
    <div class="alert error">{{ $message }}</div>
  @enderror

  <form method="POST" action="{{ route('password.email') }}" class="form">
    @csrf

    <label>Email</label>
    <input type="email" name="email" class="input" placeholder="you@example.com" required>

    <button class="btn-primary w-full mt-4">Kirim OTP</button>

    <p class="text-center mt-4 text-sm">
      Kembali ke login?
      <a href="{{ route('login') }}" data-slide="to-login" class="link">Masuk</a>
    </p>
  </form>
</div>
@endsection
