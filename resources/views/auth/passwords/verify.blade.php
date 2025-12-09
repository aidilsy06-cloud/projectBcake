@extends('auth.layouts.base')

@section('title','Verifikasi OTP — B’cake')

@section('content')
<div class="auth-card slide-in-right">

  <h2 class="title">Verifikasi OTP</h2>
  <p class="subtitle">Masukkan kode OTP yang dikirim ke email Anda.</p>

  @if (session('status'))
    <div class="alert success">{{ session('status') }}</div>
  @endif

  @error('otp')
    <div class="alert error">{{ $message }}</div>
  @enderror

  <form method="POST" action="{{ route('password.otp.check') }}" class="form">
    @csrf

    <label>Kode OTP</label>
    <input type="number" name="otp" class="input" placeholder="123456" required>

    <button class="btn-primary w-full mt-4">Verifikasi</button>

    <p class="text-center mt-4 text-sm">
      Tidak menerima OTP?
      <a href="{{ route('password.request') }}" data-slide="to-forgot" class="link">Kirim Ulang</a>
    </p>
  </form>

</div>
@endsection
