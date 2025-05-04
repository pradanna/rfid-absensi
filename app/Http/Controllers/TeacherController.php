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
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|max:20',

            // Validasi user
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat user baru
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'guru',
        ]);

        // Membuat guru dan menghubungkannya dengan user
        Teacher::create(array_merge(
            $request->only(['nip', 'name', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'no_hp']),
            ['user_id' => $user->id]
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
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nip' => 'required|max:255|unique:teachers,nip,' . $teacher->id,
            'name' => 'required|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|max:20',

            // Validasi user
            'username' => 'required|string|max:255|unique:users,username,' . $teacher->user_id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update guru
        $teacher->update([
            'nip' => $request->nip,
            'name' => $request->name,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        // Update user
        if ($teacher->user) {
            $teacher->user->username = $request->username;

            if ($request->filled('password')) {
                $teacher->user->password = Hash::make($request->password);
            }

            $teacher->user->save();
        }

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
