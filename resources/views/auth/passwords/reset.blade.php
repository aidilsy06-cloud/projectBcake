@extends('auth.layouts.base')

@section('title','Reset Password — B’cake')

@section('content')
<div class="auth-card slide-in-right">

  <h2 class="title">Reset Password</h2>
  <p class="subtitle">Masukkan password baru Anda.</p>

  @error('password')
    <div class="alert error">{{ $message }}</div>
  @enderror

  <form method="POST" action="{{ route('password.update') }}" class="form">
    @csrf

    <label>Password Baru</label>
    <input type="password" name="password" class="input" required>

    <label class="mt-3">Konfirmasi Password</label>
    <input type="password" name="password_confirmation" class="input" required>

    <button class="btn-primary w-full mt-4">Simpan Password</button>

  </form>

</div>
@endsection
