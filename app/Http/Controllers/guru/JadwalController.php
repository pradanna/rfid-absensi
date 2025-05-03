<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ScheduleSubject;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->teacher; // diasumsikan user adalah guru

        $jadwalPerHari = [];

        foreach (range(1, 7) as $day) {
            $jadwalPerHari[$day] = \App\Models\ScheduleSubject::with(['classRoom', 'subject'])
                ->where('teacher_id', $guru->id)
                ->where('day', $day)
                ->get();
        }

        return view('guru.jadwal', compact('jadwalPerHari'));
    }
}
