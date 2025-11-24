<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - DigitalParent</title>
    <style>
        /* --- 1. CSS RESET & VARIABLES --- */
        :root {
            --bg-body: #f3f4f6;       /* Abu-abu terang (Background halaman) */
            --bg-card: #ffffff;       /* Putih (Background kartu) */
            --primary: #ef4444;       /* Merah (Warna utama ikon/tombol) */
            --text-dark: #1f2937;     /* Hitam (Teks utama) */
            --text-gray: #6b7280;     /* Abu-abu (Teks label) */
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }

        body {
            background-color: var(--bg-body);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* --- 2. HEADER / TOP NAVBAR (Mirip Universitas Teknokrat) --- */
        .header {
            background-color: var(--bg-card);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .brand-text h1 {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
        }
        
        .brand-text span {
            font-size: 14px;
            color: var(--text-gray);
            font-weight: 500;
        }

        /* Tombol Logout Merah di Kanan Atas */
        .btn-logout {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.3s;
        }
        .btn-logout:hover { background-color: #dc2626; }

        /* --- 3. CONTAINER UTAMA --- */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px;
            width: 100%;
        }

        /* --- 4. TOP STATS CARDS (4 Kotak Baris Atas) --- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: var(--bg-card);
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        /* Kotak Merah Ikon */
        .icon-box {
            background-color: var(--primary);
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 24px;
            flex-shrink: 0;
        }

        .stat-info {
            text-align: right;
            flex-grow: 1;
            padding-left: 15px;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-gray);
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: var(--text-dark);
        }

        .stat-sub {
            font-size: 12px;
            color: var(--text-gray);
            margin-top: 2px;
        }

        /* Warna Status Absen */
        .text-danger { color: #dc2626; }
        .text-success { color: #16a34a; }

        /* --- 5. MAIN CONTENT SPLIT (Chart & Table) --- */
        .main-grid {
            display: grid;
            grid-template-columns: 2fr 1fr; /* Kiri Besar, Kanan Kecil */
            gap: 25px;
        }

        .content-card {
            background-color: var(--bg-card);
            border-radius: 12px;
            padding: 25px;
            box-shadow: var(--shadow);
        }

        .card-header {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            border-left: 4px solid var(--primary);
            padding-left: 10px;
        }

        /* Simulasi Chart (Placeholder) */
        .chart-placeholder {
            width: 100%;
            height: 300px;
            background: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 49px,
                #e5e7eb 50px
            );
            border-left: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
            position: relative;
            display: flex;
            align-items: flex-end;
            justify-content: space-around;
            padding-bottom: 10px;
        }

        .chart-bar {
            width: 40px;
            background-color: var(--primary);
            border-radius: 4px 4px 0 0;
            opacity: 0.8;
            transition: height 1s;
        }

        /* Tabel Sederhana di Kanan */
        .simple-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .simple-table th { text-align: left; color: var(--text-gray); padding: 10px 0; border-bottom: 1px solid #e5e7eb; }
        .simple-table td { padding: 12px 0; border-bottom: 1px solid #f3f4f6; }
        .badge-success { background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; }

        /* Responsif untuk HP */
        @media (max-width: 900px) {
            .main-grid { grid-template-columns: 1fr; }
            .header { padding: 15px 20px; }
        }
    </style>
</head>
<body>

    <header class="header">
        <div class="brand-logo">
            <div style="width: 40px; height: 40px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 20px;">DP</div>
            <div class="brand-text">
                <h1>DIGITAL PARENT</h1>
                <span>Sistem Monitoring Siswa Terpadu</span>
            </div>
        </div>

        <form action="{{ route('parent.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <span>Sign Out</span>
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </button>
        </form>
    </header>

    <div class="container">

        <div class="stats-grid">
            
            <div class="stat-card">
                <div class="icon-box">👤</div>
                <div class="stat-info">
                    <div class="stat-label">Data Siswa</div>
                    <div class="stat-value">{{ $student->name }}</div>
                    <div class="stat-sub">{{ $student->nisn }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="icon-box">📅</div>
                <div class="stat-info">
                    <div class="stat-label">Kelas / Semester</div>
                    <div class="stat-value">{{ $student->schoolClass->name ?? 'N/A' }}</div>
                    <div class="stat-sub">Tahun Ajaran 2025/2026</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="icon-box">📝</div>
                <div class="stat-info">
                    <div class="stat-label">Absensi Hari Ini</div>
                    @if($todayAttendance)
                        <div class="stat-value {{ $todayAttendance->status == 'Terlambat' ? 'text-danger' : 'text-success' }}">
                            {{ $todayAttendance->status }}
                        </div>
                        <div class="stat-sub">Jam: {{ $todayAttendance->created_at->format('H:i') }}</div>
                    @else
                        <div class="stat-value" style="color: #9ca3af;">Belum Absen</div>
                        <div class="stat-sub">Menunggu Scan...</div>
                    @endif
                </div>
            </div>

            <div class="stat-card">
                <div class="icon-box">📊</div>
                <div class="stat-info">
                    <div class="stat-label">Nilai Terakhir</div>
                    <div class="stat-value">{{ $latestGrade->score ?? '0' }}</div>
                    <div class="stat-sub">{{ $latestGrade->subject ?? 'Belum ada data' }}</div>
                </div>
            </div>

        </div>

        <div class="main-grid">
            
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">Grafik Perkembangan Nilai</h3>
                    <span style="font-size: 12px; color: gray;">● Nilai per Mapel</span>
                </div>
                
                <div class="chart-placeholder">
                    <div class="chart-bar" style="height: 40%;" title="Tugas 1"></div>
                    <div class="chart-bar" style="height: 60%;" title="Tugas 2"></div>
                    <div class="chart-bar" style="height: 85%;" title="UTS"></div>
                    <div class="chart-bar" style="height: 70%;" title="UAS"></div>
                </div>
                <div style="display: flex; justify-content: space-around; font-size: 12px; color: gray; margin-top: 10px;">
                    <span>Tugas 1</span>
                    <span>Tugas 2</span>
                    <span>UTS</span>
                    <span>UAS</span>
                </div>
            </div>

            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">Status Akademik</h3>
                </div>

                <div style="background: #f0fdf4; padding: 15px; border-radius: 8px; border: 1px solid #bbf7d0; margin-bottom: 20px;">
                    <p style="color: #15803d; font-weight: bold; font-size: 14px;">STATUS AKTIF ✅</p>
                    <p style="font-size: 12px; color: #166534; margin-top: 5px;">Siswa terdaftar aktif pada semester ini.</p>
                </div>

                <h4 style="font-size: 14px; margin-bottom: 10px; color: var(--text-dark);">Riwayat Nilai Terakhir</h4>
                <table class="simple-table">
                    <thead>
                        <tr>
                            <th>Mapel</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($student->grades()->latest()->take(3)->get() as $grade)
                        <tr>
                            <td>{{ $grade->subject }}</td>
                            <td style="font-weight: bold;">{{ $grade->score }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" style="text-align: center; color: gray;">Belum ada data nilai</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div style="margin-top: 20px;">
                    <p style="font-size: 12px; color: gray;">Wali Kelas</p>
                    <p style="font-weight: bold; font-size: 14px;">Bpk. Guru Pengajar</p>
                    <button style="width: 100%; margin-top: 10px; padding: 8px; background: #25d366; color: white; border: none; border-radius: 6px; cursor: pointer;">
                        WhatsApp Wali Kelas
                    </button>
                </div>
            </div>

        </div>

    </div>

</body>
</html>