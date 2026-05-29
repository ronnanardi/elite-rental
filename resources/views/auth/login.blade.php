<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Rental - Login</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Kustomisasi Kecil untuk Warna & Font Utama -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

</head>
<body class="d-flex align-items-center justify-content-center">

    <div class="container" style="max-width: 460px;">
        <!-- Card dengan shadow halus dan border radius besar (rounded-4) -->
        <div class="card border-0 shadow-sm rounded-4 p-4 p-sm-5 bg-white">
            
            <!-- Brand Section -->
            <div class="text-center mb-4">
                <div class="fs-4 fw-600 text-uppercase tracking-wide text-primary-custom fw-bold">
                    Elite<span class="text-dark fw-light">Rental</span>
                </div>
                <p class="text-muted small mb-0">Login untuk mulai main</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 small py-2">
                        {{ $errors->first() }}
                    </div>
                @endif
                <!-- Username Input -->
                <div class="mb-3">
                    <label class="form-label small fw-medium text-secondary">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg bg-light rounded-3 fs-6" placeholder="Email Anda" value="{{ old('email') }}" required>
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <label class="form-label small fw-medium text-secondary">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg bg-light rounded-3 fs-6" placeholder="••••••••" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary-custom btn-lg w-100 rounded-3 text-white fs-6 fw-semibold py-3">
                    Masuk Sekarang
                </button>
            </form>

            <!-- Footer Link -->
            <div class="text-center mt-4 small text-muted">
                Belum punya akun? <a href="{{ route('register') }}" class="text-primary-custom fw-semibold text-decoration-none hover-underline">Daftar Member</a>
            </div>

        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>