<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ScheduleSubject;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruDashboardController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->teacher; // diasumsikan user adalah guru
        $today = Carbon::today();

        // Ambil schedule milik guru hari ini
        $jadwalHariIni = ScheduleSubject::where('teacher_id', $guru->id)
            ->where('day', now()->isoFormat('E')) // Sesuaikan format hari
            ->get();

        $jumlahJadwalHariIni = $jadwalHariIni->count();

        // Ambil absensi berdasarkan schedule milik guru & hari ini
        $attendances = Attendance::whereIn('schedule_subject_id', $jadwalHariIni->pluck('id'))
            ->whereDate('date', Carbon::today())
            ->with(['student', 'scheduleSubject.classRoom', 'scheduleSubject.subject'])
            ->get();

        // Ambil semua siswa yang mengikuti jadwal guru ini
        $jumlahSiswa = Student::whereHas('attendances.scheduleSubject', function ($q) use ($guru) {
            $q->where('teacher_id', $guru->id);
        })->distinct()->count();

        $jadwalHariIni = ScheduleSubject::with(['classRoom', 'subject'])
            ->where('teacher_id', $guru->id)
            ->where('day', now()->isoFormat('E'))
            ->get();

        return view('guru.dashboard', [
            'jumlahSiswa' => $jumlahSiswa,
            'jumlahJadwalHariIni' => $jumlahJadwalHariIni,
            'jumlahAbsensiHariIni' => $attendances->count(),
            'jadwalHariIni' => $jadwalHariIni,
            'attendances' => $attendances,
        ]);
    }
}
