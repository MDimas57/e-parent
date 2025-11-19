<x-filament-panels::page>
    <div class="flex flex-col items-center justify-center space-y-6">
        
        <!-- Judul -->
        <div class="text-center">
            <h2 class="text-2xl font-bold text-primary-600">Scan QR Code Siswa</h2>
            <p class="text-gray-500 text-sm">Arahkan kamera ke QR Code kartu siswa.</p>
        </div>

        <!-- AREA KAMERA -->
        <div class="w-full max-w-md bg-black rounded-xl overflow-hidden shadow-lg relative">
            <!-- Tempat Kamera Muncul -->
            <div id="reader" class="w-full h-64 bg-gray-900"></div>
            
            <!-- Loading Indicator -->
            <div id="camera-loading" class="absolute inset-0 flex items-center justify-center text-white">
                <span class="animate-pulse">Memuat Kamera...</span>
            </div>
        </div>

        <!-- Form Input Manual (Backup jika kamera error) -->
        <div class="w-full max-w-md">
            <p class="text-center text-xs text-gray-400 mb-2">Atau ketik NISN manual:</p>
            <form wire:submit="save">
                <input 
                    type="text" 
                    wire:model="nisn_input" 
                    id="manual-input"
                    placeholder="Input NISN Manual..."
                    class="w-full px-4 py-3 text-lg text-center border-2 border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition"
                />
            </form>
        </div>

        <!-- Tabel Riwayat Absensi Hari Ini (Realtime) -->
        <div class="w-full mt-4 max-w-2xl">
            <h3 class="text-lg font-semibold mb-2 border-b pb-2">Absensi Masuk Hari Ini</h3>
            @php
                $todays = \App\Models\Attendance::with('student')
                            ->whereDate('date', now())
                            ->where('status', 'Hadir')
                            ->latest()
                            ->take(5)
                            ->get();
            @endphp

            <div class="bg-white rounded-lg shadow overflow-hidden">
                @if($todays->count() > 0)
                    <ul class="divide-y">
                        @foreach($todays as $row)
                            <li class="px-4 py-3 flex justify-between items-center hover:bg-gray-50 transition">
                                <div>
                                    <span class="font-bold text-gray-800">{{ $row->student->name }}</span>
                                    <div class="text-xs text-gray-500">{{ $row->student->schoolClass->name ?? '-' }}</div>
                                </div>
                                <span class="text-primary-600 font-mono font-bold bg-primary-50 px-2 py-1 rounded">
                                    {{ \Carbon\Carbon::parse($row->time)->format('H:i') }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="p-4 text-center text-gray-400 text-sm">Belum ada yang scan hari ini.</div>
                @endif
            </div>
        </div>
    </div>

    <!-- SCRIPT UNTUK KAMERA -->
    <!-- Mengambil library Html5-QRCode dari CDN -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    
    <!-- Audio Beep saat berhasil scan -->
    <audio id="scan-sound" src="https://www.soundjay.com/button/beep-07.wav"></audio>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const html5QrCode = new Html5Qrcode("reader");
            const scanSound = document.getElementById('scan-sound');
            let isProcessing = false; // Mencegah scan ganda dalam waktu cepat

            // Konfigurasi Scanner
            const config = { fps: 10, qrbox: { width: 250, height: 250 } };
            
            // Fungsi Sukses Scan
            const onScanSuccess = (decodedText, decodedResult) => {
                if (isProcessing) return; // Jika sedang memproses, abaikan
                
                isProcessing = true;
                
                // 1. Mainkan Suara Beep
                scanSound.play().catch(e => console.log("Audio play failed"));

                // 2. Masukkan data ke Input Livewire
                // @this merujuk ke komponen Livewire PHP
                @this.set('nisn_input', decodedText);

                // 3. Panggil fungsi save() di PHP
                @this.call('save').then(() => {
                    // Setelah selesai simpan, beri jeda 2 detik sebelum bisa scan lagi
                    // Agar tidak spamming database
                    setTimeout(() => {
                        isProcessing = false;
                    }, 2000);
                });
            };

            // Fungsi Error (Opsional, bisa dikosongkan agar console tidak penuh)
            const onScanFailure = (error) => {
                // console.warn(`Code scan error = ${error}`);
            };

            // Mulai Kamera
            html5QrCode.start(
                { facingMode: "environment" }, // Gunakan kamera belakang
                config,
                onScanSuccess,
                onScanFailure
            ).then(() => {
                // Hapus loading text jika kamera berhasil nyala
                document.getElementById('camera-loading').style.display = 'none';
            }).catch(err => {
                console.error("Gagal memulai kamera", err);
                document.getElementById('camera-loading').innerHTML = '<span class="text-red-500">Gagal akses kamera. Izinkan akses di browser.</span>';
            });
        });
    </script>

    <style>
        /* Perbaikan CSS agar tampilan kamera rapi */
        #reader video {
            object-fit: cover;
            border-radius: 0.75rem;
        }
    </style>
</x-filament-panels::page>