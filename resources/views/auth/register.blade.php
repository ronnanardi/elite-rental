<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Rental - Register</title>
    
    <!-- Bootstrap 5.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Kustomisasi Kecil untuk Warna & Font Utama -->
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">

</head>
<body class="min-vh-100 d-flex align-items-center justify-content-center">

    <div class="container" style="max-width: 420px;">
        <!-- Card dengan shadow halus dan border-radius besar (rounded-4 = 1rem/16px) -->
        <div class="card border-0 shadow-sm rounded-4 p-4 p-sm-5 bg-white">
            
            <!-- Brand Section -->
            <div class="text-center mb-4">
                <div class="fs-4 fw-600 text-uppercase text-primary-custom" style="letter-spacing: 0.5px;">
                    Elite<span class="text-dark fw-light">Rental</span>
                </div>
                <p class="text-muted small mb-0">Daftar Member Baru</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 small py-2">
                        {{ $errors->first() }}
                    </div>
                @endif
                <!-- Input Nama -->
                <div class="mb-3">
                    <label class="form-label small fw-medium mb-1">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control bg-light py-2 px-3 border-secondary-subtle rounded-3" placeholder="Sesuai KTP/Kartu Pelajar" value="{{ old('name') }}" required>
                </div>

                <!-- Input WA / Email -->
                <div class="mb-3">
                    <label class="form-label small fw-medium mb-1">WhatsApp / Email</label>
                    <input type="text" type="email" name="email" class="form-control bg-light py-2 px-3 border-secondary-subtle rounded-3" placeholder="Untuk info promo" value="{{ old('email') }}" required>
                </div>

                <!-- Input Password -->
                <div class="mb-4">
                    <label class="form-label small fw-medium mb-1">Buat Password</label>
                    <input type="password" name="password" class="form-control bg-light py-2 px-3 border-secondary-subtle rounded-3" placeholder="Minimal 8 karakter" required>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-medium mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control bg-light py-2 px-3 border-secondary-subtle rounded-3" 
                        placeholder="Ulangi password" required>
                </div>

                <!-- Tombol Daftar -->
                <button type="submit" class="btn btn-custom w-100 py-2 fw-semibold rounded-3 shadow-sm">Daftar Member</button>
            </form>

            <!-- Footer Link -->
            <div class="text-center mt-4 small text-muted">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-primary-custom fw-semibold text-decoration-none hover-underline">Login di sini</a>
            </div>

        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle (Opsional, untuk komponen interaktif seperti modal/dropdown) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>