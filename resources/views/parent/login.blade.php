<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Digital Parent - SMPN 1 Menggala</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- CSS VARIABLES & RESET --- */
        :root {
            --bg-body: #f3f4f6;
            --bg-card: #ffffff;
            --primary: #f59e0b; /* Oranye/emas sesuai dashboard */
            --primary-dark: #d97706; /* Varian gelap untuk hover/aksen */
            --danger: #d24900; /* Untuk status 'danger' */
            --text-dark: #1f2937;
            --text-gray: #6b7280;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        /* --- 1. BAGIAN HEADER LOGO (KIRI ATAS) --- */
        .header-logo {
            position: absolute;
            top: 20px;
            left: 30px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-logo img {
            height: 70px;
            width: auto;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .logo-text h1 {
            font-size: 22px;
            color: var(--primary);
            font-weight: 900;
            line-height: 1.1;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .logo-text .subtitle {
            font-size: 11px;
            color: var(--text-gray);
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }

        /* --- 2. BAGIAN KARTU LOGIN --- */
        .login-card {
            background-color: var(--bg-card);
            width: 100%;
            max-width: 380px;
            padding: 55px 30px 40px 30px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            position: relative;
            text-align: center;
        }

        /* Ikon Oranye Mengambang */
        .floating-icon {
            background-color: var(--primary);
            width: 70px;
            height: 70px;
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 32px;
            position: absolute;
            top: -35px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 0 5px 15px rgba(245, 158, 11, 0.3);
        }

        .login-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 10px;
            margin-top: 10px;
        }

        .login-subtitle {
            font-size: 13px;
            color: var(--text-gray);
            margin-bottom: 30px;
            font-weight: 500;
        }

        /* Password Visibility Toggle */
        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-gray);
            font-size: 16px;
            transition: color 0.3s;
        }

        .toggle-password:hover {
            color: var(--primary);
        }

        /* Remove number spinner dari input number */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        /* Input Style */
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            font-size: 14px;
            color: var(--text-dark);
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s;
            background-color: var(--bg-card);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }

        /* Placeholder styling */
        ::placeholder {
            color: var(--text-gray);
        }

        /* Tombol Submit Oranye */
        .btn-submit {
            width: 100%;
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            text-transform: uppercase;
            margin-top: 10px;
            transition: background 0.3s;
            box-shadow: 0 4px 6px rgba(245, 158, 11, 0.2);
        }

        .btn-submit:hover {
            background-color: var(--primary-dark);
        }

        /* Pesan Error */
        .error-message {
            color: var(--danger);
            font-size: 12px;
            margin-top: 4px;
            margin-left: 2px;
        }

        /* Helper Text Bawah */
        .helper-text {
            margin-top: 20px;
            font-size: 12px;
            color: var(--text-gray);
            line-height: 1.5;
        }

        /* --- 3. BAGIAN FOOTER (TENGAH BAWAH) --- */
        .footer-copyright {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 12px;
            color: var(--text-gray);
            text-align: center;
        }

        /* Responsif untuk tablet dan HP (header tetap di kiri) */
        @media (max-width: 900px) {
            .header-logo {
                top: 14px;
                left: 30px;
                transform: none;
                gap: 12px;
            }
            .header-logo img {
                height: 60px;
            }
            .logo-text h1 {
                font-size: 20px;
            }
            .login-card {
                max-width: 92%;
                padding: 48px 22px 32px;
                margin-top: 48px;
                margin-left: 30px;
                margin-right: 30px;
            }
            .floating-icon {
                width: 64px;
                height: 64px;
                top: -32px;
                font-size: 28px;
            }
        }

        @media (max-width: 480px) {
            .header-logo {
                top: 12px;
                left: 15px;
                transform: none;
                gap: 8px;
            }
            .header-logo img {
                height: 56px;
            }
            .logo-text h1 {
                font-size: 18px;
            }
            .logo-text .subtitle { font-size: 12px; }
            .login-card {
                max-width: 95%;
                padding: 40px 18px 28px;
                margin-top: 56px;
                border-radius: 10px;
                margin-left: 16px;
                margin-right: 16px;
            }
            .floating-icon {
                width: 56px;
                height: 56px;
                top: -28px;
                font-size: 26px;
            }
            .login-title { font-size: 20px; }
            .login-subtitle { font-size: 12px; margin-bottom: 18px; }
            .form-control { padding: 12px 14px; font-size: 14px; }
            .btn-submit { padding: 12px; font-size: 14px; }
            .footer-copyright { bottom: 10px; font-size: 12px; }
        }
    </style>
</head>
<body>

    <div class="header-logo">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRREfgu-nyq5Yr4kFaoeVrgSE56f4oWhaJqdA&s"
             alt="Logo Universitas Teknokrat Indonesia"
             style="height: 50px;">

        <div class="logo-text">
            <h1>SMP NEGERI 1 MENGGALA</h1>
            <div class="subtitle">Sistem Monitoring Siswa Terpadu</div>
        </div>
    </div>

    <div class="login-card">
        <div class="floating-icon">
            <i class="fas fa-graduation-cap"></i>
        </div>

        <h2 class="login-title">Digital Parent</h2>
        <p class="login-subtitle">Portal Informasi Akademik Siswa</p>

        <form action="{{ route('parent.login.submit') }}" method="POST">
            @csrf

            <div class="form-group">
                <input type="number" id="nisn" name="nisn" class="form-control" value="{{ old('nisn') }}" required placeholder="NISN Siswa">
                @error('nisn')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group password-wrapper">
                <input type="password" id="password" name="password" class="form-control" required placeholder="Tanggal Lahir (ex: 14051992)">
                <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">
                    <i class="fas fa-eye"></i>
                </button>
            </div>

            <button type="submit" class="btn-submit">SUBMIT</button>
        </form>

        <p class="helper-text">
            Silahkan melakukan Validasi Untuk Mendapatkan Informasi Akademik Siswa
        </p>
    </div>

    <div class="footer-copyright">
        <small style="color:#90a4ae; font-size:12px;">
            &copy; {{ date('Y') }}, Tim IT - SMP Negeri 1 Menggala. All rights reserved.
        </small>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.querySelector('.toggle-password i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.classList.remove('fa-eye');
                toggleButton.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleButton.classList.remove('fa-eye-slash');
                toggleButton.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
