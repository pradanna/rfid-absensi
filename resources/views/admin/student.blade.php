@extends('admin.base')

@section('content')
    <div class="dashboard">
        <div class="menu-container">
            <div class="menu overflow-hidden">
                <div class="title-container">
                    <p class="title">Inbox</p>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Data Siswa</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Siswa</button>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-striped" id="studentTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>RFID UID</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $index => $student)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $student->rfid_uid }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->phone }}</td>
                                <td>{{ $student->classroom->name ?? '-' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $student->id }}">Edit</button>
                                    <form action="{{ route('admin.student.destroy', $student->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin hapus siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Modal Edit --}}
                @foreach ($students as $student)
                    <div class="modal fade" id="editModal{{ $student->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form class="modal-content" action="{{ route('admin.student.update', $student->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Siswa</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>RFID UID</label>
                                        <input type="text" name="rfid_uid" class="form-control"
                                            value="{{ $student->rfid_uid }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Nama</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $student->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Telepon</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ $student->phone }}">
                                    </div>
                                    <div class="mb-3">
                                        <label>Kelas</label>
                                        <select name="class_room_id" class="form-control" required>
                                            @foreach ($classrooms as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ $student->class_room_id == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
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

    <!-- Modal Tambah -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('admin.student.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>RFID UID</label>
                        <input type="text" name="rfid_uid" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Telepon</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Kelas</label>
                        <select name="class_room_id" class="form-control" required>
                            @foreach ($classrooms as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
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
            $('#studentTable').DataTable();
        });
    </script>
@endsection
