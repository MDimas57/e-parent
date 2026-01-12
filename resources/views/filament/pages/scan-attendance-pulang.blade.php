<x-filament-panels::page>

<div 
    x-data="{
        qrScanner: null,
        isProcessing: false,
        isLoading: true,
        lastText: null,
        lastTime: 0,

        async initCamera() {
            if (!document.getElementById('qr-scanner-script')) {
                const script = document.createElement('script');
                script.id = 'qr-scanner-script';
                script.src = '{{ asset('js/qr-scanner.umd.min.js') }}';
                script.onload = () => {
                    QrScanner.WORKER_PATH = '{{ asset('js/qr-scanner-worker.min.js') }}';
                    this.startScanner();
                };
                document.head.appendChild(script);
            } else {
                QrScanner.WORKER_PATH = '{{ asset('js/qr-scanner-worker.min.js') }}';
                this.startScanner();
            }
        },

        startScanner() {
            if (this.qrScanner || !window.QrScanner) return;

            const videoElem = document.getElementById('reader-video');

            this.qrScanner = new QrScanner(
                videoElem,
                result => {
                    const decodedText = result.data ?? result;

                    if (decodedText === this.lastText) return;
                    this.lastText = decodedText;

                    if (this.isProcessing) return;
                    if (@this.get('is_modal_open')) return;

                    this.isProcessing = true;

                    new Audio('{{ asset('sounds/beep.wav') }}').play().catch(() => {});

                    $wire.save(decodedText).then(() => {
                        this.isProcessing = false;
                        setTimeout(() => {
                            $wire.resetScan();
                        }, 1000);
                    });
                },
                {
                    preferredCamera: 'environment',
                    maxScansPerSecond: 8,
                    highlightScanRegion: true,
                    returnDetailedScanResult: true,
                }
            );

            this.qrScanner.start()
                .then(() => {
                    console.log('Kamera Siap (Pulang)');
                    this.isLoading = false;
                })
                .catch(err => {
                    alert('Gagal akses kamera: ' + err);
                    this.isLoading = false;
                });
        }
    }"
    x-init="initCamera()"
    @resume-camera.window="
        isProcessing = false;
        lastText = null;
        lastTime = 0;
    "
>


<div class="flex flex-col items-center space-y-6">

    <div class="text-center">
        <h2 class="text-2xl font-bold text-primary-600">Scan QR Absensi Pulang</h2>
        <p class="text-sm text-gray-500">Pastikan siswa sudah absen masuk</p>
    </div>

    <div wire:ignore class="w-full max-w-md bg-black rounded-xl overflow-hidden">
        <video id="reader-video" class="w-full h-full" autoplay muted></video>
    </div>

  @if($is_modal_open)
<div class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
    <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100
            rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center animate-bounce-in">

        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full mb-4 shadow-md {{ $scanned_data['color'] }}">
            @if($scanned_data['status'] == 'success')
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 13l4 4L19 7" />
                </svg>
            @else
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856
                        c1.54 0 2.502-1.667 1.732-3L13.732 4
                        c-.77-1.333-2.694-1.333-3.464 0L3.34 16
                        c-.77 1.333.192 3 1.732 3z" />
                </svg>
            @endif
        </div>

        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
            {{ $scanned_data['title'] }}
        </h3>

        @if($scanned_data['name'])
        <div class="mt-4 bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border dark:border-gray-600">
            <p class="text-xs text-gray-500 dark:text-gray-300 uppercase">Nama Siswa</p>
            <p class="text-xl font-bold text-primary-700 dark:text-primary-400">
                {{ $scanned_data['name'] }}
            </p>
            <p class="text-sm text-gray-600 dark:text-gray-300">
                {{ $scanned_data['class'] }}
            </p>
            <p class="text-xs text-gray-400 dark:text-gray-400 mt-2">
                {{ $scanned_data['time'] }}
            </p>
        </div>
        @endif

        <p class="mt-4 text-sm text-gray-600 dark:text-gray-300">
            {{ $scanned_data['message'] }}
        </p>

    </div>
</div>
@endif


</div>
</div>

</x-filament-panels::page>
