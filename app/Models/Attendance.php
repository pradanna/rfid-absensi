<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'date',
        'time_in',
        'is_late',
        'status',
        'schedule_subject_id',
    ];

    protected $casts = [
        'time_in' => 'datetime',  // Mengkonversi time_in ke objek Carbon
    ];
    // Relasi opsional, biar bisa akses siswa langsung
    // Relasi ke model Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi ke model ScheduleSubject
    public function scheduleSubject()
    {
        return $this->belongsTo(ScheduleSubject::class);
    }
}
