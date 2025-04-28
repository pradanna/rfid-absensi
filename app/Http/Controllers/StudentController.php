<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Menampilkan daftar siswa
    public function index()
    {
        $students = Student::with('classroom')->get();
        $classrooms = ClassRoom::all(); // Ambil semua data kelas
        return view('admin.student', compact('students', 'classrooms'));
    }

    // Menyimpan siswa baru
    public function store(Request $request)
    {
        $request->validate([
            'rfid_uid' => 'required|unique:students,rfid_uid',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'class_room_id' => 'required|exists:class_rooms,id',
        ]);

        Student::create([
            'rfid_uid' => $request->rfid_uid,
            'name' => $request->name,
            'phone' => $request->phone,
            'class_room_id' => $request->class_room_id,
        ]);

        return redirect()->route('admin.student.index')->with('success', 'Siswa berhasil ditambahkan');
    }

    // Mengupdate data siswa
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'rfid_uid' => 'required|unique:students,rfid_uid,' . $student->id,
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'class_room_id' => 'required|exists:class_rooms,id',
        ]);

        $student->update([
            'rfid_uid' => $request->rfid_uid,
            'name' => $request->name,
            'phone' => $request->phone,
            'class_room_id' => $request->class_room_id,
        ]);

        return redirect()->route('admin.student.index')->with('success', 'Siswa berhasil diupdate');
    }

    // Menghapus siswa
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('admin.student.index')->with('success', 'Siswa berhasil dihapus');
    }
}
