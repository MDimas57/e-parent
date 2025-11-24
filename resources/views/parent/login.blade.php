<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Wali Murid</title>
    <style>
        /* ... copy css style dari jawaban sebelumnya ... */
        body { background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; font-family: 'Segoe UI', sans-serif; }
        .login-container { background-color: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); width: 100%; max-width: 400px; }
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; color: #333; font-weight: 500; font-size: 14px; }
        .input-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; box-sizing: border-box; }
        .btn-login { width: 100%; padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        .btn-login:hover { background-color: #0056b3; }
        .error-message { color: red; font-size: 13px; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="login-container">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="margin-bottom: 10px;">DigitalParent</h2>
            <p style="color: #666; font-size: 14px;">Silakan masuk untuk memantau siswa</p>
        </div>

        <form action="{{ route('parent.login.submit') }}" method="POST">
            @csrf
            
            <div class="input-group">
                <label for="nisn">NISN Siswa</label>
                <input type="number" id="nisn" name="nisn" value="{{ old('nisn') }}" required placeholder="Contoh: 0056789012">
                @error('nisn')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group">
                <label for="password">Password (Tanggal Lahir)</label>
                <input type="password" id="password" name="password" required placeholder="Format: DDMMYYYY (misal: 25052010)">
            </div>

            <button type="submit" class="btn-login">Masuk</button>
        </form>
        
        <p style="text-align: center; font-size: 12px; color: #888; margin-top: 20px;">
            Gunakan <strong>NISN</strong> sebagai ID dan <strong>Tanggal Lahir</strong> (HariBulanTahun) sebagai password.
        </p>
    </div>
</body>
</html>