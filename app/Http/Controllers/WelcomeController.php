<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\UserDosen;
use App\Models\UserStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    /**
     * Display the welcome/management dashboard
     */
    public function index()
    {
        // Jika user sudah login, ambil data user dan attendance
        // Jika belum login, tampilkan halaman welcome dengan data default
        
        $nama = null;
        $durasiMingguan = null;

        // Cek apakah ada user yang sudah login
        if (Auth::check()) {
            $user = Auth::user();
            $nama = $user->nama ?? null;

            // Ambil data durasi mingguan dari attendance table
            $durasiMingguan = Attendance::getDurationByDayThisWeek($user->id);
        } else {
            // Data default jika tidak ada user terautentikasi
            $nama = 'Dosen/Staff';
            $durasiMingguan = [
                'Senin' => 7.5,
                'Selasa' => 6.8,
                'Rabu' => 8.2,
                'Kamis' => 7.1,
                'Jumat' => 5.4,
            ];
        }

        return view('welcome', [
            'nama' => $nama,
            'durasiMingguan' => $durasiMingguan,
        ]);
    }

    /**
     * Get attendance data for a specific user
     * API endpoint untuk parsing data
     */
    public function getAttendanceData(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak terautentikasi',
            ], 401);
        }

        $user = Auth::user();
        $durasiMingguan = Attendance::getDurationByDayThisWeek($user->id);
        $totalJam = array_sum($durasiMingguan);

        return response()->json([
            'success' => true,
            'nama' => $user->nama,
            'durasiMingguan' => $durasiMingguan,
            'totalJam' => round($totalJam, 2),
        ]);
    }

    /**
     * Record user check-in/check-out attendance
     */
    public function recordAttendance(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak terautentikasi',
            ], 401);
        }

        $validated = $request->validate([
            'action' => 'required|in:check_in,check_out', // check_in atau check_out
        ]);

        $user = Auth::user();
        $today = now()->toDateString();

        // Cari atau buat record attendance untuk hari ini
        $attendance = Attendance::firstOrCreate(
            [
                'user_id' => $user->id,
                'tanggal' => $today,
            ],
            [
                'user_type' => $user instanceof UserDosen ? 'dosen' : 'staff',
            ]
        );

        if ($validated['action'] === 'check_in') {
            $attendance->jam_masuk = now()->toTimeString();
            $attendance->keterangan = 'hadir';
        } else {
            $attendance->jam_keluar = now()->toTimeString();

            // Hitung durasi jika sudah ada jam_masuk
            if ($attendance->jam_masuk) {
                $masuk = \Carbon\Carbon::createFromTimeString($attendance->jam_masuk);
                $keluar = \Carbon\Carbon::createFromTimeString($attendance->jam_keluar);
                $durasi = $masuk->diffInMinutes($keluar) / 60; // convert ke jam
                $attendance->durasi_jam = round($durasi, 2);
            }
        }

        $attendance->save();

        return response()->json([
            'success' => true,
            'message' => $validated['action'] === 'check_in' ? 'Check-in berhasil' : 'Check-out berhasil',
            'attendance' => $attendance,
        ]);
    }

    /**
     * Update status (online/tidak bisa diganggu)
     */
    public function updateStatus(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak terautentikasi',
            ], 401);
        }

        $validated = $request->validate([
            'status' => 'required|in:online,dnd', // dnd = do not disturb
        ]);

        $user = Auth::user();

        // Simpan status ke session atau database
        // Untuk sekarang, simpan di session
        session(['user_status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => 'Status diperbarui',
            'status' => $validated['status'],
        ]);
    }
}
