<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - DigitalParent</title>
    <style>
        /* --- 1. CSS RESET & VARIABLES --- */
        :root {
            --bg-body: #f3f4f6;
            /* Abu-abu terang */
            --bg-card: #ffffff;
            /* Putih */
            --primary: #f59e0b; /* Oranye/emas sesuai gambar */
            --primary-dark: #d97706; /* Varian gelap untuk hover/aksen */
            --danger: #d24900; /* Pengganti merah untuk status 'danger' */
            --text-dark: #1f2937;
            /* Hitam */
            --online: #16a34a; /* Warna hijau untuk status Online */
            --text-gray: #6b7280;
            /* Abu-abu */
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
            flex-direction: column;
        }

        /* --- 2. HEADER --- */
        .header {
            background-color: var(--bg-card);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
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

        .btn-logout:hover {
            background-color: var(--primary-dark);
        }

        /* --- 3. CONTAINER --- */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px;
            width: 100%;
        }

        /* --- 4. STATS CARDS --- */
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

        .text-danger {
            color: var(--danger);
        }

        .text-success {
            color: #16a34a;
        }

        /* --- 5. MAIN CONTENT --- */
        .main-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
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

        /* Simulasi Chart */
        .chart-placeholder {
            width: 100%;
            height: 300px;
            background: repeating-linear-gradient(0deg, transparent, transparent 49px, #e5e7eb 50px);
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

        .bar-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            height: 100%;
            gap: 6px;
        }

        .chart-value {
            font-size: 12px;
            color: var(--text-dark);
            background: rgba(255, 255, 255, 0.9);
            padding: 2px 6px;
            border-radius: 6px;
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.03);
            white-space: nowrap;
        }

        /* Tabel Sederhana */
        .simple-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .simple-table th {
            text-align: left;
            color: var(--text-gray);
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .simple-table td {
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }

        @media (max-width: 900px) {
            .main-grid {
                grid-template-columns: 1fr;
            }

            .header {
                padding: 15px 20px;
            }
        }

        /* Footer copyright (match login.blade.php) */
        .footer-copyright {
            position: relative;
            margin-top: auto;
            padding: 20px 30px;
            font-size: 12px;
            color: #90a4ae;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }

        /* Responsif kecil */
        @media (max-width: 480px) {
            .footer-copyright {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

    <header class="header">
        <div class="brand-logo">
            <div
                style="width: 40px; height: 40px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 20px;">
                DP</div>
            <div class="brand-text">
                <h1>DIGITAL PARENT</h1>
                <span>Sistem Monitoring Siswa Terpadu</span>
                <div style="margin-top:8px;">
                    {{-- Background diubah menjadi warna utama --}}
                    <div
                        style="display:flex; align-items:center; gap:12px; background:var(--primary); padding:8px 12px; border-radius:10px; box-shadow:var(--shadow);">
                        <div style="display:flex; flex-direction:column; line-height:1;">
                            {{-- Warna teks diubah menjadi white agar terbaca di background merah --}}
                            <div style="font-size:13px; font-weight:700; color:white;">SMP Negeri 1 Menggala</div>
                        </div>
                        <div style="margin-left:auto; display:flex; gap:8px; align-items:center;">
                            {{-- Badge disesuaikan: Background putih, Teks warna utama --}}
                            <div
                                style="background:white; color:var(--online); padding:6px 8px; border-radius:999px; font-size:11px; font-weight:700;">
                                Online</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('parent.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <span>Sign Out</span>
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
            </button>
        </form>
    </header>

    <div class="container">

        @php
            use App\Models\Grade;
            $grades = collect();
            $totalAverage = 0;

            try {
                $grades = Grade::where('student_id', $student->id)
                    ->selectRaw('subject as semester, AVG(score) as avg_score')
                    ->groupBy('subject')
                    ->orderByRaw(
                        "CASE WHEN subject LIKE 'Semester %' THEN CAST(SUBSTRING(subject, 10) AS UNSIGNED) ELSE 999 END, subject",
                    )
                    ->get();

                if ($grades->isNotEmpty()) {
                    $totalAverage = $grades->avg('avg_score');
                }
            } catch (\Throwable $e) {
                $grades = collect();
            }
        @endphp

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
                @php
                    use App\Models\SchoolSetting;
                    $academicYear = null;
                    try {
                        $setting = SchoolSetting::latest('id')->first();
                        if ($setting) {
                            $academicYear =
                                $setting->academic_year ??
                                ($setting->school_year ??
                                    ($setting->tahun_ajaran ??
                                        ((isset($setting->start_year, $setting->end_year)
                                            ? $setting->start_year . '/' . $setting->end_year
                                            : null) ??
                                            ($setting->year ?? null))));
                        }
                    } catch (\Throwable $e) {
                        $academicYear = null;
                    }
                @endphp

                <div class="stat-info">
                    <div class="stat-label">Kelas</div>
                    <div class="stat-value">{{ $student->schoolClass->name ?? 'N/A' }}</div>
                    <div class="stat-sub">Tahun Ajaran {{ $academicYear ?? 'N/A' }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="icon-box">📝</div>
                <div class="stat-info">
                    <div class="stat-label">Absensi Hari Ini</div>
                    @if ($todayAttendance)
                        <div
                            class="stat-value {{ $todayAttendance->status == 'Terlambat' ? 'text-danger' : 'text-success' }}">
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
                    <div class="stat-label">Rata-Rata Nilai</div>
                    <div class="stat-value">{{ number_format($totalAverage, 1) }}</div>
                    <div class="stat-sub">Dari {{ $grades->count() }} Semester</div>
                </div>
            </div>
        </div>

        <div class="main-grid">

            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">Grafik Perkembangan Nilai</h3>
                    <span style="font-size: 12px; color: gray;">● Nilai Rata Rata per Semester</span>
                </div>

                @if ($grades->isEmpty())
                    <div style="padding:16px; color:gray; font-size:13px;">Belum ada data nilai untuk ditampilkan.</div>
                    <div style="display: flex; gap: 10px; align-items: flex-end;">
                        <div
                            style="display: flex; flex-direction: column; justify-content: space-between; height: 300px; text-align: right; color: #9ca3af; font-size: 11px; padding-bottom: 2px;">
                            <span>100</span><span>80</span><span>60</span><span>40</span><span>20</span><span>0</span>
                        </div>
                        <div class="chart-placeholder"
                            style="flex: 1; height: 300px; background: repeating-linear-gradient(0deg, transparent, transparent 59px, #e5e7eb 60px);">
                            <div class="bar-wrap">
                                <div class="chart-value">0</div>
                                <div class="chart-bar" style="height: 5%;" title="N/A"></div>
                            </div>
                        </div>
                    </div>
                @else
                    <div style="display: flex; gap: 10px;">

                        <div
                            style="display: flex; flex-direction: column; justify-content: space-between; height: 300px; text-align: right; min-width: 25px; color: #9ca3af; font-size: 11px; font-weight: 500; padding-bottom: 0px;">
                            <span style="transform: translateY(-50%);">120</span>
                            <span style="transform: translateY(-50%);">100</span>
                            <span style="transform: translateY(-50%);">80</span>
                            <span style="transform: translateY(-50%);">60</span>
                            <span style="transform: translateY(-50%);">40</span>
                            <span style="transform: translateY(-50%);">20</span>
                            <span style="transform: translateY(50%);">0</span>
                        </div>

                        <div style="flex: 1; display: flex; flex-direction: column;">

                            <div class="chart-placeholder"
                                style="position: relative; width: 100%; height: 300px; background: repeating-linear-gradient(0deg, transparent, transparent 49px, #e5e7eb 50px); border-top: 1px dashed #e5e7eb; display: flex; align-items: flex-end; justify-content: space-around;">

                                {{-- LOGIKA UNTUK GARIS (TREND LINE) --}}
                                @php
                                    $count = $grades->count();
                                    $polylinePoints = '';
                                    $circles = [];
                                    $maxScale = 120; // Skala maksimal baru

                                    foreach ($grades as $index => $grade) {
                                        $avg = round($grade->avg_score, 1);

                                        // Hitung tinggi dalam PERSEN berdasarkan skala 120
                                        // Rumus: (Nilai / 120) * 100
                                        $percentHeight = ($avg / $maxScale) * 100;
                                        $h = min(max($percentHeight, 0), 100);

                                        // Hitung posisi X dan Y untuk SVG
                                        $posX = (($index * 2 + 1) / ($count * 2)) * 100;
                                        $posY = 100 - $h; // Y di SVG dari atas ke bawah

                                        $polylinePoints .= "{$posX},{$posY} ";
                                        $circles[] = ['x' => $posX, 'y' => $posY];
                                    }
                                @endphp

                                {{-- SVG Overlay untuk Garis --}}
                                <svg style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 10;"
                                    preserveAspectRatio="none" viewBox="0 0 100 100">
                                    <polyline points="{{ $polylinePoints }}" fill="none" stroke="#3b82f6"
                                        stroke-width="2" vector-effect="non-scaling-stroke" />

                                    @foreach ($circles as $circle)
                                        <circle cx="{{ $circle['x'] }}" cy="{{ $circle['y'] }}" r="0.6"
                                            fill="#3b82f6" stroke="none" />
                                    @endforeach
                                </svg>

                                {{-- BATANG GRAFIK --}}
                                @foreach ($grades as $grade)
                                    @php
                                        $avg = round($grade->avg_score, 1);
                                        // Hitung tinggi batang berdasarkan skala 120
                                        $percentHeight = ($avg / $maxScale) * 100;
                                        $height = min(max($percentHeight, 0), 100);
                                    @endphp
                                    <div class="bar-wrap" style="z-index: 5;">
                                        <div class="chart-value" style="font-weight: bold; color: var(--primary);">
                                            {{ $avg }}</div>
                                        <div class="chart-bar"
                                            style="height: {{ $height }}%; width: 40px; border-radius: 6px 6px 0 0;"
                                            title="Semester {{ $grade->semester }} — {{ $avg }}"></div>
                                    </div>
                                @endforeach
                            </div>

                            <div
                                style="display: flex; justify-content: space-around; font-size: 12px; color: #4b5563; margin-top: 10px; font-weight: 500;">
                                @foreach ($grades as $grade)
                                    <div style="width: 40px; text-align: center;">
                                        {{ $grade->semester }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">Status Akademik</h3>
                </div>

                <div
                    style="background: #f0fdf4; padding: 15px; border-radius: 8px; border: 1px solid #bbf7d0; margin-bottom: 20px;">
                    <p style="color: #15803d; font-weight: bold; font-size: 14px;">STATUS AKTIF ✅</p>
                    <p style="font-size: 12px; color: #166534; margin-top: 5px;">Siswa terdaftar aktif pada semester
                        ini.</p>
                </div>

                <h4 style="font-size: 14px; margin-bottom: 10px; color: var(--text-dark);">Pesan dari Wali Kelas</h4>

                @php
                    use Carbon\Carbon;
                    $messages = collect();
                    $teacherUserId = optional(optional($student->schoolClass)->teacher)->user_id ?? null;
                    $parentUserId = auth()->id();

                    if ($teacherUserId && $parentUserId) {
                        try {
                            $messages = \App\Models\Message::where('sender_id', $teacherUserId)
                                ->where('receiver_id', $parentUserId)
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
                        } catch (\Throwable $e) {
                            $messages = collect();
                        }
                    }
                @endphp

                @if ($messages->isEmpty())
                    <div style="padding:12px; color:gray; font-size:13px;">Belum ada pesan dari wali kelas.</div>
                @else
                    <ul style="list-style:none; padding:0; margin:0;">
                        @foreach ($messages as $message)
                            <li style="padding:10px 0; border-bottom:1px solid #f3f4f6;">
                                <div style="display:flex; justify-content:space-between; align-items:center;">
                                    <div style="font-size:12px; color:var(--text-gray);">
                                        {{ $message->created_at ? Carbon::parse($message->created_at)->format('d M Y H:i') : '' }}
                                    </div>
                                </div>
                                <div style="margin-top:6px; font-size:13px; color:#374151;">
                                    {{ $message->content ?? '-' }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <div style="margin-top: 20px;">
                    <p style="font-size: 12px; color: gray;">Wali Kelas</p>
                    <p style="font-weight: bold; font-size: 14px;">
                        {{ $student->schoolClass->teacher->name ?? 'Belum ditentukan' }}
                    </p>

                    @php
                        $teacherPhone = $student->schoolClass->teacher->phone ?? null;

                        // Ambil data siswa untuk template chat
                        $studentName = $student->name ?? '';
                        $className = $student->schoolClass->name ?? '';

                        // Buat isi pesan (gunakan \n untuk baris baru)
                        $message =
                            "Assalamualaikum/Selamat Pagi Bapak/Ibu Wali Kelas.\n\n" .
                            "Saya orang tua/wali murid dari:\n" .
                            "Nama: *$studentName*\n" .
                            "Kelas: *$className*\n\n" .
                            'Mohon maaf mengganggu waktunya, saya ingin menanyakan perihal...';

                        // Format phone untuk WhatsApp API
                        // Hapus leading 0 dan tambahkan country code 62 (Indonesia) jika belum ada
                        $formattedPhone = $teacherPhone;
                        if ($formattedPhone) {
                            // Hilangkan karakter yang tidak perlu (spasi, dash, +)
                            $formattedPhone = preg_replace('/[^\d]/', '', $formattedPhone);
                            // Jika diawali 0, ganti dengan 62
                            if (strpos($formattedPhone, '0') === 0) {
                                $formattedPhone = '62' . substr($formattedPhone, 1);
                            }
                            // Jika belum dimulai dengan 62, tambahkan
                            elseif (strpos($formattedPhone, '62') !== 0) {
                                $formattedPhone = '62' . $formattedPhone;
                            }
                        }
                    @endphp

                    @if ($teacherPhone)
                        {{-- Format nomor dengan country code 62 untuk WhatsApp API --}}
                        <a href="https://wa.me/{{ $formattedPhone }}?text={{ urlencode($message) }}" target="_blank"
                            style="text-decoration: none;">
                            <button
                                style="width: 100%; margin-top: 10px; padding: 8px; background: #25d366; color: white; border: none; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z">
                                    </path>
                                </svg>
                                <span style="font-size: 14px; font-weight: 600;">WhatsApp Wali Kelas</span>
                            </button>
                        </a>
                    @else
                        <button disabled
                            style="width: 100%; margin-top: 10px; padding: 8px; background: #d1d5db; color: #6b7280; border: none; border-radius: 6px; cursor: not-allowed;">
                            WhatsApp Tidak Tersedia
                        </button>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <div class="footer-copyright">
        &copy; 2025, Tim IT - SMP Negeri 1 Menggala. All rights reserved.
    </div>
</body>

</html>
