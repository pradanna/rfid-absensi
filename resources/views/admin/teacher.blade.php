@extends('admin.base')

@section('content')
    <div class="dashboard">
        <div class="menu-container">
            <div class="menu overflow-hidden">
                <div class="title-container">
                    <p class="title">Data Guru</p>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Data Guru</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Guru</button>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-striped" id="teacherTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>No. HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($teachers as $index => $teacher)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $teacher->nip }}</td>
                                <td>{{ $teacher->name }}</td>
                                <td>{{ $teacher->tanggal_lahir }}</td>
                                <td>{{ $teacher->jenis_kelamin }}</td>
                                <td>{{ $teacher->alamat }}</td>
                                <td>{{ $teacher->no_hp }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $teacher->id }}">Edit</button>
                                    <form action="{{ route('admin.teacher.destroy', $teacher->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin hapus guru ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">Tidak ada data guru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Modal Edit --}}
                @foreach ($teachers as $teacher)
                    <div class="modal fade" id="editModal{{ $teacher->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form class="modal-content" action="{{ route('admin.teacher.update', $teacher->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Guru</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>NIP</label>
                                        <input type="text" name="nip" class="form-control"
                                            value="{{ $teacher->nip }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Nama</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $teacher->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" class="form-control"
                                            value="{{ $teacher->tanggal_lahir }}">
                                    </div>
                                    <div class="mb-3">
                                        <label>Jenis Kelamin</label>
                                        <select name="jenis_kelamin" class="form-control">
                                            <option value="Laki-laki"
                                                {{ $teacher->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                            </option>
                                            <option value="Perempuan"
                                                {{ $teacher->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Alamat</label>
                                        <textarea name="alamat" class="form-control">{{ $teacher->alamat }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label>No. HP</label>
                                        <input type="text" name="no_hp" class="form-control"
                                            value="{{ $teacher->no_hp }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('admin.teacher.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>NIP</label>
                        <input type="text" name="nip" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>No. HP</label>
                        <input type="text" name="no_hp" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('morejs')
    <script>
        $(document).ready(function() {
            $('#teacherTable').DataTable();
        });
    </script>
@endsection
