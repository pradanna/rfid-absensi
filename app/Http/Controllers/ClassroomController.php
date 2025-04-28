<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = ClassRoom::all();
        return view('admin.kelas', compact('classrooms'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        ClassRoom::create($request->only('name'));
        return back()->with('success', 'Kelas berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required']);
        $class = ClassRoom::findOrFail($id);
        $class->update($request->only('name'));
        return back()->with('success', 'Kelas berhasil diubah');
    }

    public function destroy($id)
    {
        ClassRoom::findOrFail($id)->delete();
        return back()->with('success', 'Kelas berhasil dihapus');
    }
}
