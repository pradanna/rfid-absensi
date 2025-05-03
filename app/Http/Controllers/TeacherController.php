<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User; // Import model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash; // Import untuk hash password

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::all();
        return view('admin.teacher', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|unique:teachers|max:255',
            'name' => 'required|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan', // Update enum values
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|max:20',
            'user_id' => 'nullable|exists:users,id', // Pastikan tabel users ada
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat user baru
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make('password'), // Set default password, sebaiknya ubah ini
            'role' => 'teacher', // Set role sebagai teacher
        ]);

        // Membuat guru dan menghubungkannya dengan user
        $teacher = Teacher::create(array_merge(
            $request->all(),
            ['user_id' => $user->id] // Hubungkan dengan ID user yang baru dibuat
        ));

        return redirect()->route('admin.teacher.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        return view('admin.teacher.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        return view('admin.teacher.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|unique:teachers,nip,' . $teacher->id . '|max:255',
            'name' => 'required|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan', // Update enum values
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|max:20',
            'user_id' => 'nullable|exists:users,id', // Pastikan tabel users ada
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $teacher->update($request->all());

        return redirect()->route('admin.teacher.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('admin.teacher.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
