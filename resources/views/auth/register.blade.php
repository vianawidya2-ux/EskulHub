<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Eskul Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* --- RESET & GLOBAL --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            display: flex; justify-content: center; align-items: center;
            min-height: 100vh; background-color: #ffffff; padding: 20px;
        }

        .register-container {
            width: 100%; max-width: 380px; display: flex;
            flex-direction: column; align-items: center; text-align: center;
        }

        /* --- LOGO AREA --- */
        .logo-area { margin-bottom: 20px; }
        .logo-area img { width: 90px; height: 90px; object-fit: cover; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .brand-name { font-size: 24px; font-weight: 800; color: #0d2a6b; margin-top: 10px; }
        .app-text { font-size: 12px; color: #e67e22; font-weight: 600; margin-top: -3px; letter-spacing: 2px; text-transform: uppercase; }

        /* --- FORM AREA --- */
        form { width: 100%; display: flex; flex-direction: column; gap: 12px; }

        /* --- INPUT SHAPE (HEXAGON) --- */
        .input-wrapper { position: relative; width: 100%; margin-bottom: 5px; }
        .input-group {
            position: relative; background-color: #f1f5f9;
            border-top: 2px solid #cbd5e1; border-bottom: 2px solid #cbd5e1;
            height: 44px; margin-left: 20px; margin-right: 20px;
        }

        .input-group::before { content: ""; position: absolute; left: -22px; top: -2px; border-top: 22px solid transparent; border-bottom: 22px solid transparent; border-right: 22px solid #cbd5e1; pointer-events: none; }
        .inner-left { position: absolute; left: -19px; top: 0px; border-top: 20px solid transparent; border-bottom: 20px solid transparent; border-right: 19px solid #f1f5f9; z-index: 1; pointer-events: none; }
        
        .input-group::after { content: ""; position: absolute; right: -22px; top: -2px; border-top: 22px solid transparent; border-bottom: 22px solid transparent; border-left: 22px solid #cbd5e1; pointer-events: none; }
        .inner-right { position: absolute; right: -19px; top: 0px; border-top: 20px solid transparent; border-bottom: 20px solid transparent; border-left: 19px solid #f1f5f9; z-index: 1; pointer-events: none; }

        .custom-input {
            width: 100%; height: 100%; background: transparent; border: none; outline: none;
            padding: 0 10px; font-size: 11px; font-weight: 700; text-align: center;
            position: relative; z-index: 20; color: #1e293b;
        }

        select.custom-input { appearance: none; cursor: pointer; text-align-last: center; }

        /* Warna khusus per kategori */
        .bg-eskul { background-color: #e0f2fe !important; border-top-color: #38bdf8 !important; border-bottom-color: #38bdf8 !important; }
        .bg-eskul::before { border-right-color: #38bdf8 !important; }
        .bg-eskul::after { border-left-color: #38bdf8 !important; }
        .inner-eskul-l { border-right-color: #e0f2fe !important; }
        .inner-eskul-r { border-left-color: #e0f2fe !important; }

        .bg-kelas { background-color: #f0fdf4 !important; border-top-color: #4ade80 !important; border-bottom-color: #4ade80 !important; }
        .bg-kelas::before { border-right-color: #4ade80 !important; }
        .bg-kelas::after { border-left-color: #4ade80 !important; }
        .inner-kelas-l { border-right-color: #f0fdf4 !important; }
        .inner-kelas-r { border-left-color: #f0fdf4 !important; }

        .bg-pembina { background-color: #fffbeb !important; border-top-color: #f59e0b !important; border-bottom-color: #f59e0b !important; }
        .bg-pembina::before { border-right-color: #f59e0b !important; }
        .bg-pembina::after { border-left-color: #f59e0b !important; }
        .inner-pembina-l { border-right-color: #fffbeb !important; }
        .inner-pembina-r { border-left-color: #fffbeb !important; }

        .error-msg { color: #dc2626; font-size: 9px; font-weight: bold; margin-top: 4px; display: block; text-align: center; text-transform: uppercase; }
        .helper-text { font-size: 8px; color: #64748b; margin-top: 6px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }

        .btn-register { 
            background: none; border: none; font-size: 28px; font-weight: 900; 
            color: #0f172a; cursor: pointer; margin-top: 10px; transition: 0.3s;
            letter-spacing: -1px;
        }
        .btn-register:hover { transform: scale(1.08); color: #2563eb; }

        .footer-link { margin-top: 15px; font-size: 13px; color: #64748b; }
        .footer-link a { color: #2563eb; text-decoration: none; font-weight: 700; }
    </style>
</head>
<body>

    <div class="register-container">
        <div class="logo-area">
            <img src="{{ asset('images/logo 3.0.jpeg') }}" alt="Logo">
            <div class="brand-name">Ekskul Hub</div>
            <div class="app-text">Application</div>
        </div>

        <form action="{{ route('register') }}" method="POST" autocomplete="off">
            @csrf

            {{-- Nama --}}
            <div class="input-wrapper">
                <div class="input-group">
                    <div class="inner-left"></div>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="NAMA LENGKAP" class="custom-input" required autofocus autocomplete="off">
                    <div class="inner-right"></div>
                </div>
                @error('name') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Email --}}
            <div class="input-wrapper">
                <div class="input-group">
                    <div class="inner-left"></div>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="EMAIL ADDRESS" class="custom-input" required autocomplete="off">
                    <div class="inner-right"></div>
                </div>
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Pilihan Eskul --}}
            <div class="input-wrapper">
                <div class="input-group bg-eskul">
                    <div class="inner-left inner-eskul-l"></div>
                    <select name="eskul" id="eskul" class="custom-input" required autocomplete="off">
                        <option value="" selected disabled>PILIH UNIT ESKUL</option>
                        <option value="Pramuka" {{ old('eskul') == 'Pramuka' ? 'selected' : '' }}>PRAMUKA</option>
                        <option value="Futsal" {{ old('eskul') == 'Futsal' ? 'selected' : '' }}>FUTSAL</option>
                        <option value="Rohis" {{ old('eskul') == 'Rohis' ? 'selected' : '' }}>ROHIS</option>
                        <option value="Paskibra" {{ old('eskul') == 'Paskibra' ? 'selected' : '' }}>PASKIBRA</option>
                        <option value="Padus" {{ old('eskul') == 'Padus' ? 'selected' : '' }}>PADUAN SUARA</option>
                        <option value="Silat" {{ old('eskul') == 'Silat' ? 'selected' : '' }}>PENCAK SILAT</option>
                        <option value="Jepang" {{ old('eskul') == 'Jepang' ? 'selected' : '' }}>BAHASA JEPANG</option>
                        <option value="Dance" {{ old('eskul') == 'Dance' ? 'selected' : '' }}>DANCE</option>
                        <option value="Badminton" {{ old('eskul') == 'Badminton' ? 'selected' : '' }}>BADMINTON</option>
                        <option value="PMR" {{ old('eskul') == 'PMR' ? 'selected' : '' }}>PMR</option>
                        <option value="Tari" {{ old('eskul') == 'Tari' ? 'selected' : '' }}>TARI</option>
                        <option value="ADMIN" id="opt-admin" {{ old('eskul') == 'ADMIN' ? 'selected' : '' }} style="display:none;">ADMIN</option>
                    </select>
                    <div class="inner-right inner-eskul-r"></div>
                </div>
                @error('eskul') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Pilihan Kelas --}}
            <div class="input-wrapper">
                <div class="input-group bg-kelas">
                    <div class="inner-left inner-kelas-l"></div>
                    <select name="kelas" id="kelas" class="custom-input" required autocomplete="off">
                        <option value="" selected disabled>PILIH KELAS ANDA</option>
                        <optgroup label="KELAS X">
                            <option value="X FARMASI 1">X FARMASI 1</option>
                            <option value="X FARMASI 2">X FARMASI 2</option>
                            <option value="X FARMASI 3">X FARMASI 3</option>
                            <option value="X TJKT 1">X TJKT 1</option>
                            <option value="X TJKT 2">X TJKT 2</option>
                            <option value="X TK 1">X TK 1</option>
                            <option value="X TK 2">X TK 2</option>
                            <option value="X TM 1">X TM 1</option>
                            <option value="X TM 2">X TM 2</option>
                            <option value="X KDS 1">X KDS 1</option>
                        </optgroup>
                        <optgroup label="KELAS XI">
                            <option value="XI FARMASI 1">XI FARMASI 1</option>
                            <option value="XI FARMASI 2">XI FARMASI 2</option>
                            <option value="XI FARMASI 3">XI FARMASI 3</option>
                            <option value="XI FARMASI 4">XI FARMASI 4</option>
                            <option value="XI TJKT 1">XI TJKT 1</option>
                            <option value="XI TJKT 2">XI TJKT 2</option>
                            <option value="XI TJKT 3">XI TJKT 3</option>
                            <option value="XI TK 1">XI TK 1</option>
                            <option value="XI TK 2">XI TK 2</option>
                            <option value="XI TM 1">XI TM 1</option>
                            <option value="XI TM 2">XI TM 2</option>
                            <option value="XI KDS 1">XI KDS 1</option>
                        </optgroup>
                        <optgroup label="KELAS XII">
                            <option value="XII FARMASI 1">XII FARMASI 1</option>
                            <option value="XII FARMASI 2">XII FARMASI 2</option>
                            <option value="XII FARMASI 3">XII FARMASI 3</option>
                            <option value="XII TJKT 1">XII TJKT 1</option>
                            <option value="XII TJKT 2">XII TJKT 2</option>
                            <option value="XII TK 1">XII TK 1</option>
                            <option value="XII TK 2">XII TK 2</option>
                            <option value="XII TM 1">XII TM 1</option>
                            <option value="XII TM 2">XII TM 2</option>
                        </optgroup>
                        <option value="-" id="opt-strip" style="display:none;">-</option>
                    </select>
                    <div class="inner-right inner-kelas-r"></div>
                </div>
                @error('kelas') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Password --}}
            <div class="input-wrapper">
                <div class="input-group">
                    <div class="inner-left"></div>
                    <input type="password" name="password" placeholder="PASSWORD BARU" class="custom-input" required autocomplete="off">
                    <div class="inner-right"></div>
                </div>
            </div>

            {{-- Konfirmasi Password --}}
            <div class="input-wrapper">
                <div class="input-group">
                    <div class="inner-left"></div>
                    <input type="password" name="password_confirmation" placeholder="KONFIRMASI PASSWORD" class="custom-input" required autocomplete="off">
                    <div class="inner-right"></div>
                </div>
                @error('password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <hr style="border: 0; border-top: 1px dashed #cbd5e1; margin: 10px 0;">

            {{-- Input Kode Akses --}}
            <div class="input-wrapper">
                <div class="input-group bg-pembina">
                    <div class="inner-left inner-pembina-l"></div>
                    <input type="text" name="kode_akses" id="kode_akses" placeholder="KODE RAHASIA (OPSIONAL)" class="custom-input" value="{{ old('kode_akses') }}" autocomplete="off">
                    <div class="inner-right inner-pembina-r"></div>
                </div>
                <p class="helper-text">Khusus Admin/Pembina. Siswa kosongkan saja.</p>
                @error('kode_akses') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn-register">REGISTER</button>

            <div class="footer-link">
                Sudah punya akun? <a href="{{ route('login') }}">Login</a>
            </div>
        </form>
    </div>

    <script>
        const kodeInput = document.getElementById('kode_akses');
        const kelasSelect = document.getElementById('kelas');
        const eskulSelect = document.getElementById('eskul');
        const optAdmin = document.getElementById('opt-admin');
        const optStrip = document.getElementById('opt-strip');

        kodeInput.addEventListener('input', function() {
            const val = this.value.trim().toUpperCase();
            
            if (val === "ADMIN-SUPER") {
                optStrip.style.display = "block";
                optAdmin.style.display = "block";
                kelasSelect.value = "-";
                eskulSelect.value = "ADMIN";
            } else if (val === "PEMBINA-SMK") {
                optStrip.style.display = "block";
                optAdmin.style.display = "none";
                kelasSelect.value = "-";
            } else {
                optStrip.style.display = "none";
                optAdmin.style.display = "none";
                if (kelasSelect.value === "-") kelasSelect.value = "";
                if (eskulSelect.value === "ADMIN") eskulSelect.value = "";
            }
        });
    </script>
</body>
</html>