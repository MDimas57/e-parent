<x-filament-panels::page>
    
    {{-- 
        WRAPPER UTAMA 
        x-data: Mengontrol status kamera dan loading
    --}}
    <div 
        x-data="{
            scanner: null,
            isProcessing: false,
            isLoading: true, // <-- VARIABLE BARU: Defaultnya Loading
            initCamera() {
                if (!document.getElementById('html5-qrcode-script')) {
                    let script = document.createElement('script');
                    script.id = 'html5-qrcode-script';
                    script.src = 'https://unpkg.com/html5-qrcode';
                    script.onload = () => this.startScanner();
                    document.head.appendChild(script);
                } else {
                    this.startScanner();
                }
            },
            startScanner() {
                if (this.scanner) return;

                this.scanner = new Html5Qrcode('reader');
                const config = { fps: 10, qrbox: { width: 250, height: 250 } };

                this.scanner.start(
                    { facingMode: 'environment' }, 
                    config, 
                    (decodedText) => {
                        // SAAT SUKSES SCAN
                        if (this.isProcessing) return;
                        if (@this.get('is_modal_open')) return;

                        console.log('QR Detected:', decodedText);
                        this.isProcessing = true;
                        
                        new Audio('https://www.soundjay.com/button/beep-07.wav').play().catch(() => {});

                        $wire.save(decodedText).then(() => {
                            setTimeout(() => { this.isProcessing = false; }, 2000);
                        });
                    },
                    (errorMessage) => {
                        // Biarkan kosong agar tidak spam console
                    }
                ).then(() => {
                    // --- PERBAIKAN UTAMA DI SINI ---
                    // Saat kamera berhasil nyala, matikan loading
                    console.log('Kamera Siap!');
                    this.isLoading = false; 
                }).catch(err => {
                    console.error('Camera Fail:', err);
                    alert('Gagal akses kamera: ' + err);
                    this.isLoading = false; // Hilangkan loading meski error
                });
            }
        }"
        x-init="initCamera()"
        @resume-camera.window="isProcessing = false"
    >

        <div class="flex flex-col items-center justify-center space-y-6 relative">

            {{-- HEADER --}}
            <div class="text-center">
                <h2 class="text-2xl font-bold text-primary-600">Scan QR Code Siswa</h2>
                <p class="text-gray-500 text-sm">Kamera aktif. Pastikan QR Code jelas.</p>
            </div>

            {{-- AREA KAMERA --}}
            <div wire:ignore class="w-full max-w-md bg-black rounded-xl overflow-hidden shadow-lg relative min-h-[350px]">
                
                {{-- VIDEO ELEMENT --}}
                <div id="reader" class="w-full h-full bg-gray-900"></div>
                
                {{-- LOADING OVERLAY (Dikontrol oleh x-show="isLoading") --}}
                <div 
                    x-show="isLoading" 
                    class="absolute inset-0 flex items-center justify-center bg-black text-white z-10"
                >
                    <div class="flex flex-col items-center">
                        <svg class="animate-spin h-8 w-8 text-white mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="font-bold">Menyiapkan Kamera...</span>
                    </div>
                </div>

            </div>

            {{-- MODAL POPUP (HASIL SCAN) --}}
            @if($is_modal_open)
                <div class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
                    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center animate-bounce-in">
                        
                        {{-- Ikon --}}
                        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full mb-4 shadow-md {{ $scanned_data['color'] }}">
                            @if($scanned_data['status'] == 'success')
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            @endif
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900">{{ $scanned_data['title'] }}</h3>

                        @if(isset($scanned_data['name']))
                            <div class="mt-4 bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <p class="text-xs text-gray-500 uppercase">Nama Siswa</p>
                                <p class="text-xl font-bold text-primary-700">{{ $scanned_data['name'] }}</p>
                                <p class="text-sm text-gray-600 mt-1">{{ $scanned_data['class'] }}</p>
                                <p class="text-xs text-gray-400 mt-2">{{ $scanned_data['time'] }}</p>
                            </div>
                        @endif

                        <p class="mt-4 text-gray-600 text-sm">{{ $scanned_data['message'] }}</p>

                        <button wire:click="resetScan" class="mt-6 w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-3 bg-primary-600 text-base font-bold text-white hover:bg-primary-700 focus:outline-none">
                            Scan Selanjutnya
                        </button>
                    </div>
                </div>
            @endif

            {{-- INPUT MANUAL --}}
            <div class="w-full max-w-md mt-8">
                <form wire:submit="save">
                    <input type="text" wire:model="nisn_input" placeholder="Input NISN Manual..." class="block w-full pl-4 pr-3 py-2 border border-gray-300 rounded-lg text-center shadow-sm" />
                </form>
            </div>

        </div>
    </div>

    <style>
        @keyframes bounce-in { 0% { transform: scale(0.9); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
        .animate-bounce-in { animation: bounce-in 0.2s ease-out forwards; }
        #reader video { object-fit: cover; border-radius: 0.75rem; width: 100% !important; height: 100% !important; }
    </style>

</x-filament-panels::page>