<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use Carbon\Carbon;

class ParentController extends Controller
{
    // ... (fungsi showLoginForm dan login biarkan tetap sama) ...
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->role === 'parent') {
            return redirect()->route('parent.dashboard');
        }
        return view('parent.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nisn'     => 'required|numeric',
            'password' => 'required',
        ]);

        $emailFormat = $request->nisn . '@orangtua.id';

        if (Auth::attempt(['email' => $emailFormat, 'password' => $request->password])) {
            $request->session()->regenerate();

            if (Auth::user()->role !== 'parent') {
                Auth::logout();
                return back()->withErrors(['nisn' => 'Akun ini bukan akun Wali Murid.']);
            }

            return redirect()->intended(route('parent.dashboard'));
        }

        return back()->withErrors([
            'nisn' => 'NISN atau Password (Tanggal Lahir) salah.',
        ]);
    }

    // --- BAGIAN YANG DIUBAH ADA DI SINI ---
    public function dashboard()
    {
        $user = Auth::user();
        
        // Perhatikan bagian 'schoolClass.teacher'
        // Ini artinya: Ambil Student -> Ambil Kelasnya -> Ambil Guru (Teacher) dari kelas itu
        $student = Student::with(['schoolClass.teacher']) 
                          ->where('user_id', $user->id)
                          ->first();

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