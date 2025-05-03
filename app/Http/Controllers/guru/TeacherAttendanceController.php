<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ScheduleSubject;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $guru = auth()->user()->teacher;

        // Ambil semua schedule milik guru
        $scheduleIds = \App\Models\ScheduleSubject::where('teacher_id', $guru->id)->pluck('id');

        // Filter
        $query = \App\Models\Attendance::with(['student', 'scheduleSubject.classroom', 'scheduleSubject.subject', 'scheduleSubject.teacher'])
            ->whereIn('schedule_subject_id', $scheduleIds);

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('class_id')) {
            $query->whereHas('scheduleSubject.classroom', function ($q) use ($request) {
                $q->where('id', $request->class_id);
            });
        }

        if ($request->filled('subject_id')) {
            $query->whereHas('scheduleSubject.subject', function ($q) use ($request) {
                $q->where('id', $request->subject_id);
            });
        }

        $attendances = $query->latest()->paginate(20);

        // Ambil semua kelas dan mapel yang pernah diajarkan guru ini
        $classes = \App\Models\ClassRoom::whereIn(
            'id',
            \App\Models\ScheduleSubject::where('teacher_id', $guru->id)->pluck('class_id')->unique()
        )->get();

        $subjects = \App\Models\Subject::whereIn(
            'id',
            \App\Models\ScheduleSubject::where('teacher_id', $guru->id)->pluck('subject_id')->unique()
        )->get();

        return view('guru.attendance.index', [
            'attendances' => $attendances,
            'filters' => $request->only(['date', 'class_id', 'subject_id']),
            'classes' => $classes,
            'subjects' => $subjects,
        ]);
    }
}
