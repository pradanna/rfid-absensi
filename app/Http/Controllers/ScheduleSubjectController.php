<?php


namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\ScheduleSubject;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ScheduleSubjectController extends Controller
{
    public function index()
    {
        $schedules = ScheduleSubject::with(['subject', 'teacher', 'classRoom'])->get();
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $classes = ClassRoom::all();

        return view('admin.schedule_subject', compact('schedules', 'subjects', 'teachers', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required',
            'teacher_id' => 'required',
            'class_id' => 'required',
            'day' => 'required',
            'time_in' => 'required',
            'time_out' => 'required',
        ]);

        ScheduleSubject::create($request->all());

        return redirect()->route('admin.schedule.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $schedule = ScheduleSubject::findOrFail($id);

        $request->validate([
            'subject_id' => 'required',
            'teacher_id' => 'required',
            'class_id' => 'required',
            'day' => 'required',
            'time_in' => 'required',
            'time_out' => 'required',
        ]);

        $schedule->update($request->all());

        return redirect()->route('admin.schedule.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy($id)
    {
        $schedule = ScheduleSubject::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.schedule.index')->with('success', 'Jadwal berhasil dihapus');
    }
}
