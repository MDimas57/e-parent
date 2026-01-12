{{-- File: resources/views/filament/admin/logo.blade.php --}}
<div class="flex items-center justify-start gap-3"> 
    {{-- 1. Gambar Logo --}}
    <img src="{{ asset('images/logo smp.png') }}" 
         alt="Logo Sekolah" 
         class="h-11 w-auto shadow-sm rounded-full"> 

    {{-- 2. Teks di samping logo --}}
    {{-- Ubah text-center menjadi text-left agar teks rata kiri --}}
    <div class="font-bold text-lg leading-tight text-gray-900 dark:text-white text-left">
        Digital Parent<br>
        SMP N 1 Menggala
    </div>
</div>