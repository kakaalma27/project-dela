@extends('welcome')
@section('center')

<input type="checkbox" id="show">
<label for="show" class="show-btn">View Form</label>
<div class="container">
    <label for="show" class="close-btn fas fa-times" title="close"></label>
    <div class="text">
        Pendaftaran
    </div>

    @if($errors->any())
        <div id="notification" class="notification">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="data">
            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nama') }}</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
        </div>
        <div class="data">
            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Alamat Email') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
        </div>
        <div class="data">
            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
        </div>
        <div class="data">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Konfirmasi Password') }}</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        </div>
        <div class="forgot-pass">
            <a href="#">Forgot Password?</a>
        </div>
        <div class="btn">
            <div class="inner"></div>
            <button type="submit">
                {{ __('Register') }}
            </button>     
        </div>
        <div class="signup-link">
            Punya Akun? <a href="{{ route('login') }}">Login</a>
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
