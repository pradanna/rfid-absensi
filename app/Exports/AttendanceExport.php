<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;

class AttendanceExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Attendance::with(['student', 'scheduleSubject.subject', 'scheduleSubject.classroom', 'scheduleSubject.teacher']);

        if ($this->request->filled('date')) {
            $query->whereDate('date', $this->request->date);
        }

        if ($this->request->filled('class_id')) {
            $query->whereHas('scheduleSubject', fn($q) => $q->where('class_id', $this->request->class_id));
        }

        if ($this->request->filled('subject_id')) {
            $query->whereHas('scheduleSubject', fn($q) => $q->where('subject_id', $this->request->subject_id));
        }

        $attendances = $query->get();

        return $attendances->map(function ($att) {
            return [
                'Nama Siswa' => $att->student->name ?? '-',
                'Kelas' => $att->scheduleSubject->classroom->name ?? '-',
                'Mapel' => $att->scheduleSubject->subject->nama_mapel ?? '-',
                'Guru' => $att->scheduleSubject->teacher->name ?? '-',
                'Tanggal' => $att->date,
                'Jam Masuk' => $att->time_in,
                'Terlambat?' => $att->is_late ? 'Ya' : 'Tidak',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Kelas',
            'Mapel',
            'Guru',
            'Tanggal',
            'Jam Masuk',
            'Terlambat?',
        ];
    }
}
