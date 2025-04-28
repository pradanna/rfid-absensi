@extends('admin.base')

@section('content')
    <div class="dashboard">
        <div class="menu-container  ">
            <div class="menu overflow-hidden">
                <div class="title-container">
                    <p class="title">Inbox</p>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Data Kelas</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Kelas</button>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-striped" id="classroomTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classrooms as $index => $class)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $class->name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $class->id }}">Edit</button>
                                    <form action="{{ route('admin.classroom.destroy', $class->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin hapus kelas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @foreach ($classrooms as $class)
                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal{{ $class->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form class="modal-content" action="{{ route('admin.classroom.update', $class->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Kelas</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nama Kelas</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $class->name }}" required>
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
            <form class="modal-content" action="{{ route('admin.classroom.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Kelas</label>
                        <input type="text" name="name" class="form-control" required>
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
            $('#classroomTable').DataTable();
        });
    </script>
@endsection
