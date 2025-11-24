<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Digital Parent - SMPN 1 Menggala</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Reset CSS */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: #f4f6f9; /* Warna background abu-abu terang */
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        /* --- 1. BAGIAN HEADER LOGO (KIRI ATAS) --- */
        .header-logo {
            position: absolute;
            top: 25px;
            left: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-logo img {
            height: 50px; /* Sesuaikan ukuran logo asli Anda */
            width: auto;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .logo-text h1 {
            font-size: 18px;
            color: #d32f2f; /* Merah sesuai tema */
            font-weight: 800;
            line-height: 1.2;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .logo-text p {
            font-size: 13px;
            color: #1a237e; /* Biru tua */
            font-weight: 600;
            letter-spacing: 1px;
        }

        /* --- 2. BAGIAN KARTU LOGIN --- */
        .login-card {
            background-color: white;
            width: 100%;
            max-width: 380px; /* Lebar kartu */
            padding: 55px 30px 40px 30px; /* Padding atas lebih besar untuk ikon */
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); /* Bayangan halus */
            position: relative;
            text-align: center;
        }

        /* Ikon Merah Mengambang */
        .floating-icon {
            background-color: #e53935; /* Warna Merah */
            width: 70px;
            height: 70px;
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 32px;

            /* Posisi Absolute agar 'nangkring' di atas */
            position: absolute;
            top: -35px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 0 5px 15px rgba(229, 57, 53, 0.3);
        }

        .login-title {
            font-size: 24px;
            font-weight: 700;
            color: #455a64; /* Abu-abu gelap */
            margin-bottom: 30px;
            margin-top: 10px;
        }

        /* Input Style */
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #cfd8dc;
            border-radius: 6px;
            font-size: 14px;
            color: #333;
            outline: none;
            transition: border-color 0.3s;
            background-color: #fff;
        }

        .form-control:focus {
            border-color: #90a4ae;
            box-shadow: 0 0 0 3px rgba(207, 216, 220, 0.4);
        }

        /* Placeholder styling */
        ::placeholder {
            color: #b0bec5;
        }

        /* Tombol Submit Hijau */
        .btn-submit {
            width: 100%;
            background-color: #4caf50; /* Hijau */
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
            box-shadow: 0 4px 6px rgba(76, 175, 80, 0.2);
        }

        .btn-submit:hover {
            background-color: #43a047;
        }

        /* Pesan Error */
        .error-message {
            color: #e53935;
            font-size: 12px;
            margin-top: 4px;
            margin-left: 2px;
        }

        /* Helper Text Bawah */
        .helper-text {
            margin-top: 20px;
            font-size: 12px;
            color: #78909c;
            line-height: 1.5;
        }

        /* --- 3. BAGIAN FOOTER (KIRI BAWAH) --- */
        .footer-copyright {
            position: absolute;
            bottom: 20px;
            left: 30px;
            font-size: 12px;
            color: #90a4ae;
        }

        /* Responsif untuk HP */
        @media (max-width: 480px) {
            .header-logo { top: 15px; left: 15px; }
            .footer-copyright { bottom: 15px; left: 15px; text-align: center; width: 100%; left: 0; }
        }
    </style>
</head>
<body>

    <div class="header-logo">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Logo_Tut_Wuri_Handayani.png/1200px-Logo_Tut_Wuri_Handayani.png"
             alt="Logo Sekolah"
             style="height: 50px;">

        <div class="logo-text">
            <h1>SMP NEGERI 1</h1>
            <p>MENGGALA</p>
        </div>
    </div>

    <div class="login-card">
        <div class="floating-icon">
            <i class="fas fa-graduation-cap"></i>
        </div>

        <h2 class="login-title">Digital Parent</h2>

        <form action="{{ route('parent.login.submit') }}" method="POST">
            @csrf

            <div class="form-group">
                <input type="number" id="nisn" name="nisn" class="form-control" value="{{ old('nisn') }}" required placeholder="NISN Siswa">
                @error('nisn')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="password" id="password" name="password" class="form-control" required placeholder="Tanggal Lahir (ex: 14051992)">
            </div>

            <button type="submit" class="btn-submit">SUBMIT</button>
        </form>

        <p class="helper-text">
            Silahkan melakukan validasi untuk mendapatkan Informasi Akademik Siswa
        </p>
    </div>

    <div class="footer-copyright">
        &copy; 2025, Tim IT - SMP Negeri 1 Menggala. All rights reserved.
    </div>

</body>
</html>
