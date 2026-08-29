<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Penjadwalan Klarifikasi Mediasi P3MI</title>
    <link rel="icon" type="image/png" href="{{ asset('images/kp2mi-favicon.png') }}?v=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f8f6f1, #f1ede3);
            font-family: 'Segoe UI', sans-serif;
        }

        .login-wrapper {
            height: 100vh;
        }

        .login-card {
            width: 900px;
            max-width: 95%;
            min-height: 500px;
            background: #ffffff;
            box-shadow: 0 15px 40px rgba(0,0,0,0.08);
        }

        .right-panel {
            background: linear-gradient(180deg, #c8a75e, #a8873f);
            color: white;
        }

        .right-panel img {
            width: 300px;
        }

        .system-title span {
            color: #ffd97a;
            font-weight: bold;
        }

        .btn-gold {
            background-color: #b8944f;
            color: white;
            border: none;
        }

        .btn-gold:hover {
            background-color: #a07f3e;
            color: white;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #b8944f;
        }

        .left-title {
            font-weight: 600;
            color: #333;
        }

        .subtitle {
            font-size: 14px;
            color: #888;
        }

        .forgot-password {
    color: #a07f3e;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    transition: 0.2s;
}

.forgot-password:hover {
    color: #80632d;
    text-decoration: underline;
}
    </style>
</head>

<body>

<div class="d-flex justify-content-center align-items-center login-wrapper">

    <div class="row login-card rounded overflow-hidden">

        <!-- LEFT SIDE -->
        <div class="col-md-6 p-5">

            <h2 class="left-title mb-2">Login</h2>
            <p class="subtitle mb-4">Masuk ke akun Anda</p>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Username -->
                <div class="mb-3 input-group">
                    <span class="input-group-text bg-light">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text"
                           name="username"
                           class="form-control @error('username') is-invalid @enderror"
                           placeholder="Username"
                           value="{{ old('username') }}"
                           required autofocus>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3 input-group">
                    <span class="input-group-text bg-light">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Password"
                           required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

<!-- Remember & Forgot Password -->
<div class="d-flex justify-content-between align-items-center mb-4">

    <div class="form-check mb-0">
        <input
            class="form-check-input"
            type="checkbox"
            name="remember"
            id="remember"
        >

        <label class="form-check-label" for="remember">
            Remember me
        </label>
    </div>

    @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}"
           class="forgot-password">

            Lupa Password?

        </a>
    @endif

</div>

                <button type="submit" class="btn btn-gold w-100">
                    LOGIN
                </button>

            </form>
        </div>


        <!-- RIGHT SIDE -->
        <div class="col-md-6 right-panel d-flex flex-column justify-content-center align-items-center text-center p-4">

            <img src="{{ asset('images/KlarifMediasiLogo-removebg.png') }}" class="mb-4">

            <h5 class="fw-bold">
                SISTEM PENJADWALAN
            </h5>

            <h5 class="fw-bold">
                KLARIFIKASI & MEDIASI
            </h5>

            <h5 class="fw-bold mt-2">
                P3MI
            </h5>

        </div>

    </div>

</div>

</body>
</html>
