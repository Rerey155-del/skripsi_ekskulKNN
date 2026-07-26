<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login EkskulKNN</title>
    <link rel="stylesheet" href="{{ asset('css/knn_style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="display:flex; align-items:center; justify-content:center; min-height:100vh; padding:24px;">
    <div class="glass-card" style="width:min(440px,100%);">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <img src="{{ asset('assets/MTSN 2 Pesisir Selatan.png') }}" alt="Logo MTsN 2 Pesisir Selatan" style="max-height: 90px; width: auto; object-fit: contain; margin-bottom: 0.75rem; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));">
            <h1 style="font-size:1.5rem; margin-bottom:0.35rem;">MTsN 2 Pesisir Selatan</h1>
            <p style="color:var(--text-muted); font-size: 0.9rem;">Sistem Rekomendasi Ekstrakurikuler (KNN)</p>
        </div>

        @if ($errors->any())
            <div class="alert danger" style="margin-bottom:1rem;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf
            <div class="input-field" style="margin-bottom:1rem;">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan email">
            </div>
            <div class="input-field" style="margin-bottom:1rem;">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Masukkan password">
            </div>
            <label style="display:flex; align-items:center; gap:0.5rem; color:var(--text-muted); margin-bottom:1.25rem;">
                <input type="checkbox" name="remember" value="1" style="width:auto;">
                Ingat saya
            </label>
            <button type="submit" class="btn-primary" style="width:100%;"><i class="fa-solid fa-right-to-bracket"></i> Masuk</button>
        </form>
    </div>
</body>
</html>
