<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\ScheduleSubject;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rfid_uid' => 'required|string',
        ]);

        $student = Student::where('rfid_uid', $request->rfid_uid)->first();

        if (!$student) {
            return response()->json([
                'status' => 'error',
                'message' => 'Siswa tidak ditemukan'
            ], 404);
        }

        $todayDate = now()->toDateString();
        $now = now();
        $todayDayNumber = $now->dayOfWeekIso; // 1 = Senin, 7 = Minggu

        if ($todayDayNumber > 6) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hari ini tidak ada absensi',
                'phone' => $student->phone
            ], 400);
        }

        $scheduleSubjects = ScheduleSubject::where('class_id', $student->class_room_id)
            ->where('day', $todayDayNumber)
            ->get();

        if ($scheduleSubjects->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada jadwal untuk hari ini',
                'phone' => $student->phone
            ], 404);
        }

        $selectedSchedule = $scheduleSubjects->first(function ($schedule) use ($now) {
            $todayDate = $now->toDateString();
            $timeIn = Carbon::createFromFormat('Y-m-d H:i:s', $todayDate . ' ' . $schedule->time_in);
            $timeOut = Carbon::createFromFormat('Y-m-d H:i:s', $todayDate . ' ' . $schedule->time_out);

            // Cek apakah waktu sekarang berada dalam rentang 15 menit sebelum time_in dan 15 menit setelah time_out
            $earlyTime = $timeIn->copy()->subMinutes(15);  // 15 menit sebelum time_in
            $lateTime = $timeOut->copy()->subMinutes(15);  // 15 menit setelah time_out

            return $now->between($earlyTime, $lateTime);
        });

        if (!$selectedSchedule) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jadwal tidak ada atau waktu absensi sudah lewat',
                'phone' => $student->phone
            ], 400);
        }

        $existing = Attendance::whereDate('date', $todayDate)
            ->where('student_id', $student->id)
            ->where('schedule_subject_id', $selectedSchedule->id)
            ->where('status', 'masuk')
            ->first();

        $subjectName = optional($selectedSchedule->subject)->nama_mapel;
        $teacherName = optional($selectedSchedule->teacher)->name;

        if ($existing) {
            return response()->json([
                'status' => 'info',
                'message' => 'Siswa sudah absen untuk jadwal ini',
                'nama' => $student->name,
                'mapel' => $subjectName,
                'guru' => $teacherName,
                'phone' => $student->phone,
            ], 200);
        }

        $isLate = $now->gt(Carbon::parse($selectedSchedule->time_in));

        Attendance::create([
            'student_id' => $student->id,
            'schedule_subject_id' => $selectedSchedule->id,
            'date' => $todayDate,
            'time_in' => $now->toTimeString(),
            'is_late' => $isLate,
            'status' => 'masuk',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Absensi berhasil',
            'nama' => $student->name,
            'is_late' => $isLate,
            'mapel' => $subjectName,
            'guru' => $teacherName,
            'phone' => $student->phone,
        ], 200);
    }
}
