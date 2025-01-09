<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-4">
        <h1 class="text-center mb-4">Data Mahasiswa</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tombol Tambah Data -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addStudentModal">Tambah Data</button>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->nim }}</td>
                        <td>{{ $student->nama }}</td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="showDetails({{ $student->id }})">Detail</button>
                            <button class="btn btn-warning btn-sm" onclick="showUpdateForm({{ $student->id }})">Update</button>
                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $students->links() }}

        <!-- Modal Tambah Data -->
        <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStudentModalLabel">Tambah Mahasiswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" class="form-control" id="nim" name="nim" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Detail Mahasiswa -->
        <div class="modal fade" id="detailStudentModal" tabindex="-1" aria-labelledby="detailStudentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailStudentModalLabel">Detail Mahasiswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="studentDetails">
                            <!-- Konten dinamis akan dimuat di sini -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form id="deleteStudentForm" action="" method="POST" style="display: inline;">
                            
                            
                        </form>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Update Data -->
        <div class="modal fade" id="updateStudentModal" tabindex="-1" aria-labelledby="updateStudentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" id="updateForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateStudentModalLabel">Update Mahasiswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="updateNim" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="updateNim" name="nim" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateNama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="updateNama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateTempatLahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="updateTempatLahir" name="tempat_lahir" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateTanggalLahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="updateTanggalLahir" name="tanggal_lahir" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateJenisKelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-control" id="updateJenisKelamin" name="jenis_kelamin" required>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="updateFoto" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="updateFoto" name="foto">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showDetails(id) {
    fetch(`/students/${id}`)
        .then(response => response.json())
        .then(data => {
            const details = `
                <p><strong>NIM:</strong> ${data.nim}</p>
                <p><strong>Nama:</strong> ${data.nama}</p>
                <p><strong>Tempat Lahir:</strong> ${data.tempat_lahir}</p>
                <p><strong>Tanggal Lahir:</strong> ${data.tanggal_lahir}</p>
                <p><strong>Jenis Kelamin:</strong> ${data.jenis_kelamin}</p>
                <p><strong>Foto:</strong></p>
                <img src="/storage/${data.foto}" alt="${data.nama}" class="img-fluid">
            `;
            document.getElementById('studentDetails').innerHTML = details;

            document.getElementById('deleteStudentForm').action = `/students/${id}`;

            const detailModal = new bootstrap.Modal(document.getElementById('detailStudentModal'));
            detailModal.show();
        });
}function showDetails(id) {
    fetch(`/students/${id}`)
        .then(response => response.json())
        .then(data => {
            const details = `
                <p><strong>NIM:</strong> ${data.nim}</p>
                <p><strong>Nama:</strong> ${data.nama}</p>
                <p><strong>Tempat Lahir:</strong> ${data.tempat_lahir}</p>
                <p><strong>Tanggal Lahir:</strong> ${data.tanggal_lahir}</p>
                <p><strong>Jenis Kelamin:</strong> ${data.jenis_kelamin}</p>
                <p><strong>Foto:</strong></p>
                <img src="/storage/${data.foto}" alt="${data.nama}" class="img-fluid">
            `;
            document.getElementById('studentDetails').innerHTML = details;

            const detailModal = new bootstrap.Modal(document.getElementById('detailStudentModal'));
            detailModal.show();
        });
}

    
        function showUpdateForm(id) {
            fetch(`/students/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    // Menampilkan data mahasiswa pada form update
                    document.getElementById('updateNim').value = data.nim;
                    document.getElementById('updateNama').value = data.nama;
                    document.getElementById('updateTempatLahir').value = data.tempat_lahir;
                    document.getElementById('updateTanggalLahir').value = data.tanggal_lahir;
                    document.getElementById('updateJenisKelamin').value = data.jenis_kelamin;
    
                    // Mengubah aksi form update dengan ID mahasiswa
                    const form = document.getElementById('updateForm');
                    form.action = `/students/${id}`;
    
                    // Menampilkan modal
                    const updateModal = new bootstrap.Modal(document.getElementById('updateStudentModal'));
                    updateModal.show();
                });
        }
    </script>
        
</body>

</html>
