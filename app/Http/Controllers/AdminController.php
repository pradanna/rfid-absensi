<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\ScheduleSubject;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $query = Attendance::with(['student', 'scheduleSubject.subject', 'scheduleSubject.classroom', 'scheduleSubject.teacher']);

        // Ambil tanggal hari ini menggunakan Carbon
        $today = Carbon::today(); // Mengambil tanggal tanpa waktu

        // Filter berdasarkan tanggal hari ini
        $query->whereDate('date', $today);

        if ($request->filled('class_id')) {
            $query->whereHas('scheduleSubject', fn($q) => $q->where('class_id', $request->class_id));
        }

        if ($request->filled('subject_id')) {
            $query->whereHas('scheduleSubject', fn($q) => $q->where('subject_id', $request->subject_id));
        }

        $attendances = $query->latest()->paginate(10);

        return view('admin.dashboard', [
            'attendances' => $attendances,
            'classes' => ClassRoom::all(),
            'subjects' => ScheduleSubject::with('subject')->get()->pluck('subject')->unique('id'),
            'filters' => $request->only('class_id', 'subject_id'),
        ]);
    }
}
