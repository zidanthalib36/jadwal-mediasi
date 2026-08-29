<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Lupa Password - Sistem Penjadwalan Klarifikasi Mediasi P3MI</title>

    <link rel="icon" type="image/png"
        href="{{ asset('images/kp2mi-favicon.png') }}?v=1">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
        rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f8f6f1, #f1ede3);
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
        }

        .login-wrapper {
            min-height: 100vh;
            padding: 20px;
        }

        .login-card {
            width: 900px;
            max-width: 95%;
            min-height: 500px;
            background: #ffffff;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        }

        /* =========================
           LEFT PANEL
        ========================= */

        .left-panel {
            padding: 55px;
        }

        .left-title {
            font-weight: 600;
            color: #333;
        }

        .subtitle {
            font-size: 14px;
            color: #888;
        }

        .description {
            font-size: 14px;
            line-height: 1.7;
            color: #777;
        }

        /* =========================
           INPUT
        ========================= */

        .input-group-text {
            background-color: #f8f8f8;
            border-color: #dee2e6;
            color: #8d733d;
        }

        .form-control {
            height: 46px;
            border-color: #dee2e6;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #b8944f;
        }

        /* =========================
           BUTTON
        ========================= */

        .btn-gold {
            background-color: #b8944f;
            color: white;
            border: none;
            height: 46px;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn-gold:hover {
            background-color: #a07f3e;
            color: white;
        }

        /* =========================
           BACK TO LOGIN
        ========================= */

        .back-login {
            color: #a07f3e;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .back-login:hover {
            color: #80632d;
        }

        /* =========================
           RIGHT PANEL
        ========================= */

        .right-panel {
            background: linear-gradient(180deg, #c8a75e, #a8873f);
            color: white;
        }

        .right-panel img {
            width: 300px;
            max-width: 85%;
        }

        .system-title {
            font-size: 18px;
            letter-spacing: 0.5px;
        }

        .system-subtitle {
            font-size: 15px;
            opacity: 0.95;
        }

        /* =========================
           ALERT
        ========================= */

        .alert {
            font-size: 13px;
            border-radius: 8px;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 767px) {

            .login-wrapper {
                padding: 15px;
            }

            .login-card {
                min-height: auto;
            }

            .left-panel {
                padding: 35px 25px;
            }

            .right-panel {
                display: none !important;
            }

            .left-title {
                font-size: 26px;
            }
        }
    </style>
</head>

<body>

<div class="d-flex justify-content-center align-items-center login-wrapper">

    <div class="row login-card rounded overflow-hidden">

        <!-- =========================================
             LEFT SIDE - FORGOT PASSWORD
        ========================================== -->

        <div class="col-md-6 left-panel">

            <h2 class="left-title mb-2">
                Lupa Password?
            </h2>

            <p class="subtitle mb-3">
                Reset password akun Anda
            </p>

            <p class="description mb-4">
                Jangan khawatir. Masukkan alamat email yang terdaftar
                pada akun Anda. Kami akan mengirimkan tautan untuk
                membuat password baru.
            </p>


            <!-- Session Status -->

            @if (session('status'))
                <div class="alert alert-success d-flex align-items-center mb-4">

                    <i class="bi bi-check-circle-fill me-2"></i>

                    <span>
                        {{ session('status') }}
                    </span>

                </div>
            @endif


            <!-- Form -->

            <form method="POST" action="{{ route('password.email') }}">

                @csrf


                <!-- Email -->

                <div class="mb-3">

                    <label for="email"
                           class="form-label fw-semibold"
                           style="font-size: 14px;">

                        Email

                    </label>

                    <div class="input-group">

                        <span class="input-group-text">

                            <i class="bi bi-envelope"></i>

                        </span>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Masukkan email Anda"
                            value="{{ old('email') }}"
                            required
                            autofocus
                        >

                    </div>

                    @error('email')

                        <div class="text-danger mt-2"
                             style="font-size: 13px;">

                            <i class="bi bi-exclamation-circle me-1"></i>

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                <!-- Submit -->

                <button type="submit"
                        class="btn btn-gold w-100 mb-3">

                    <i class="bi bi-envelope-paper me-2"></i>

                    KIRIM LINK RESET PASSWORD

                </button>


                <!-- Back Login -->

                <div class="text-center">

                    <a href="{{ route('login') }}"
                       class="back-login">

                        <i class="bi bi-arrow-left me-1"></i>

                        Kembali ke Login

                    </a>

                </div>

            </form>

        </div>


        <!-- =========================================
             RIGHT SIDE - BRANDING
        ========================================== -->

        <div class="col-md-6 right-panel
                    d-flex flex-column
                    justify-content-center
                    align-items-center
                    text-center p-4">

            <img
                src="{{ asset('images/KlarifMediasiLogo-removebg.png') }}"
                class="mb-4"
                alt="Logo Klarifikasi Mediasi"
            >

            <h5 class="fw-bold system-title mb-1">
                SISTEM PENJADWALAN
            </h5>

            <h5 class="fw-bold system-title mb-1">
                KLARIFIKASI & MEDIASI
            </h5>

            <h5 class="fw-bold system-subtitle mt-2">
                P3MI
            </h5>

        </div>

    </div>

</div>

</body>

</html>
```
