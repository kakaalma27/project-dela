@extends('welcome')
@section('center')

<input type="checkbox" id="show">
<label for="show" class="show-btn">View Form</label>
<div class="container">
    <label for="show" class="close-btn fas fa-times" title="close"></label>
    <div class="text">
        Masuk
    </div>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    @if(session('error'))
        <div id="notification" class="notification">
            <p>{{ session('error') }}</p>
        </div>
    @endif
   <form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="data">
        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Alamat Email') }}</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

        @error('email')
            <span class="invalid-feedback" role="alert">
                <p>{{ $message }}</p>
            </span>
        @enderror
    </div>
    <div class="data">
        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

        @error('password')
            <span class="invalid-feedback" role="alert">
                <p>{{ $message }}</p>
            </span>
        @enderror
    </div>

    <div class="btn">
       <div class="inner"></div>
       <button type="submit" id="login-button">{{ __('Login') }}</button>
    </div>
    <div class="signup-link">
       Belum Punya akun? <a href="{{ route('register') }}">Daftar</a>
    </div>
   </form>
</div>




<script>
    // Ambil elemen notifikasi
    var notification = document.getElementById('notification');

    // Fungsi untuk menutup notifikasi setelah 3 detik
    function closeNotification() {
        notification.style.display = 'none';
    }

    // Setelah halaman dimuat, tunggu 3 detik dan tutup notifikasi
    window.onload = function() {
        setTimeout(closeNotification, 5000);
    }
</script>
@endsection


