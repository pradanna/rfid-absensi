<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return view('admin.subject', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama_mapel' => 'required']);
        Subject::create($request->only('nama_mapel'));
        return back()->with('success', 'Mata Pelajaran berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama_mapel' => 'required']);
        $classRoom = Subject::findOrFail($id);
        $classRoom->update($request->only('nama_mapel'));
        return back()->with('success', 'Mata Pelajaran  berhasil diubah');
    }

    public function destroy($id)
    {
        Subject::findOrFail($id)->delete();
        return back()->with('success', 'Mata Pelajaran  berhasil dihapus');
    }
}
