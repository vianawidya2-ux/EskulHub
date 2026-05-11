<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ekskul Hub</title>
    <style>
        /* --- RESET & GLOBAL --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #ffffff; /* Background Polos */
        }

        .login-container {
            width: 100%;
            max-width: 350px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 20px;
        }

        /* --- LOGO AREA --- */
        .logo-area {
            margin-bottom: 30px;
        }

        .logo-area img {
            width: 140px; /* Ukuran logo disesuaikan */
            height: auto;
        }

        .brand-name {
            font-size: 28px;
            font-weight: bold;
            color: #0d2a6b; /* Biru Gelap */
            margin-top: 5px;
        }

        .app-text {
            font-size: 16px;
            color: #e67e22; /* Oranye */
            margin-top: -5px;
            text-transform: capitalize;
        }

        /* --- FORM AREA --- */
        form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 20px;
        }

        /* --- INPUT SHAPE (BENTUK PANAH / HEXAGON) --- */
        .input-wrapper {
            position: relative;
            width: 100%;
            margin-bottom: 5px;
        }

        .input-group {
            position: relative;
            background-color: #d1d5db; /* Abu-abu sesuai desain */
            border-top: 2px solid #6b7280;
            border-bottom: 2px solid #6b7280;
            height: 55px;
            margin-left: 22px; /* Ruang untuk ujung kiri */
            margin-right: 22px; /* Ruang untuk ujung kanan */
        }

        /* Ujung Kiri Lancip */
        .input-group::before {
            content: "";
            position: absolute;
            left: -24px;
            top: -2px;
            border-top: 27.5px solid transparent;
            border-bottom: 27.5px solid transparent;
            border-right: 24px solid #6b7280; /* Warna border */
        }

        .inner-left {
            position: absolute;
            left: -21px;
            top: 0px;
            border-top: 25.5px solid transparent;
            border-bottom: 25.5px solid transparent;
            border-right: 21px solid #d1d5db; /* Warna background input */
            z-index: 1;
        }

        /* Ujung Kanan Lancip */
        .input-group::after {
            content: "";
            position: absolute;
            right: -24px;
            top: -2px;
            border-top: 27.5px solid transparent;
            border-bottom: 27.5px solid transparent;
            border-left: 24px solid #6b7280; /* Warna border */
        }

        .inner-right {
            position: absolute;
            right: -21px;
            top: 0px;
            border-top: 25.5px solid transparent;
            border-bottom: 25.5px solid transparent;
            border-left: 21px solid #d1d5db; /* Warna background input */
            z-index: 1;
        }

        .custom-input {
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            padding: 0 10px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            position: relative;
            z-index: 5;
        }

        /* Error Message */
        .error-msg {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        /* --- LOGIN BUTTON --- */
        .btn-submit {
            background: none;
            border: none;
            font-size: 32px;
            font-weight: bold;
            color: #000;
            cursor: pointer;
            margin-top: 20px;
            transition: transform 0.2s;
        }

        .btn-submit:hover {
            transform: scale(1.1);
        }

        /* Link Register (Opsional) */
        .footer-link {
            margin-top: 15px;
            font-size: 14px;
        }
        .footer-link a {
            color: #0d2a6b;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="login-container">
        
        <div class="logo-area">
            <img src="{{ asset('images/logo 3.0.jpeg') }}">
            <!-- <div class="brand-name">Ekskul Hub</div>
            <div class="app-text">Application</div> -->
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="input-wrapper">
                <div class="input-group">
                    <div class="inner-left"></div>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email" class="custom-input" required autofocus>
                    <div class="inner-right"></div>
                </div>
                @error('email')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-wrapper">
                <div class="input-group">
                    <div class="inner-left"></div>
                    <input type="password" name="password" placeholder="Password" class="custom-input" required>
                    <div class="inner-right"></div>
                </div>
                @error('password')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                Login
            </button>

            <div class="footer-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
            </div>

        </form>

    </div>

</body>
</html>