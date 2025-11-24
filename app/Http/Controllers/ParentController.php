<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use Carbon\Carbon;

class ParentController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->role === 'parent') {
            return redirect()->route('parent.dashboard');
        }
        return view('parent.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi input NISN (bukan email)
        $request->validate([
            'nisn'     => 'required|numeric', // Inputnya berupa angka
            'password' => 'required',
        ]);

        // 2. Manipulasi: Gabungkan NISN dengan domain palsu agar cocok dengan database
        $emailFormat = $request->nisn . '@orangtua.id';

        // 3. Coba Login
        if (Auth::attempt(['email' => $emailFormat, 'password' => $request->password])) {
            $request->session()->regenerate();

            if (Auth::user()->role !== 'parent') {
                Auth::logout();
                return back()->withErrors(['nisn' => 'Akun ini bukan akun Wali Murid.']);
            }

            return redirect()->intended(route('parent.dashboard'));
        }

        // Jika Gagal
        return back()->withErrors([
            'nisn' => 'NISN atau Password (Tanggal Lahir) salah.',
        ]);
    }

    // ... (Fungsi dashboard & logout tetap sama seperti sebelumnya)
    public function dashboard()
    {
        $user = Auth::user();
        $student = Student::with(['schoolClass'])->where('user_id', $user->id)->first();

        if (!$student) return abort(404, 'Data siswa tidak ditemukan.');

        $todayAttendance = $student->attendances()->whereDate('created_at', Carbon::today())->first();
        $latestGrade = $student->grades()->latest()->first();

        return view('parent.dashboard', compact('student', 'todayAttendance', 'latestGrade'));
    }
    
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}