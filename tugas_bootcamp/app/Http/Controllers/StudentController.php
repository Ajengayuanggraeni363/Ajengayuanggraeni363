<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::paginate(10); // Menggunakan paginate untuk mendukung links()
        return view('index', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:students,nim',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'foto' => 'required|image|max:2048',
        ]);

        $fotoPath = $request->file('foto')->store('photos', 'public');

        Student::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('students.index')->with('success', 'Data mahasiswa berhasil ditambahkan!');
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'nim' => 'required|unique:students,nim,' . $id,
        'nama' => 'required',
        'tempat_lahir' => 'required',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk file gambar
    ]);

    $student = Student::findOrFail($id);

    // Update data mahasiswa
    $student->nim = $request->nim;
    $student->nama = $request->nama;
    $student->tempat_lahir = $request->tempat_lahir;
    $student->tanggal_lahir = $request->tanggal_lahir;
    $student->jenis_kelamin = $request->jenis_kelamin;

    // Proses gambar jika ada file baru
    if ($request->hasFile('foto')) {
        // Hapus gambar lama jika ada
        if ($student->foto && Storage::disk('public')->exists($student->foto)) {
            Storage::disk('public')->delete($student->foto);
        }

        // Simpan gambar baru
        $fotoPath = $request->file('foto')->store('photos', 'public');
        $student->foto = $fotoPath;
    }

    $student->save();

    return redirect()->route('students.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
}


    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        // Hapus file foto jika ada
        if ($student->foto) {
            Storage::disk('public')->delete($student->foto);
        }

        $student->delete();

        return redirect()->route('students.index')->with('success', 'Data mahasiswa berhasil dihapus!');
    }
}
