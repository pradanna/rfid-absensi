@extends('admin.base')

@section('content')
    <div class="dashboard">
        <div class="menu-container">
            <div class="menu overflow-hidden">
                <div class="title-container">
                    <p class="title">Inbox</p>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Data Mapel</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Mapel</button>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-striped" id="subjectTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mapel</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subjects as $index => $subject)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $subject->nama_mapel }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $subject->id }}">Edit</button>
                                    <form action="{{ route('admin.subject.destroy', $subject->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin hapus mapel ini?')">
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
                @foreach ($subjects as $subject)
                    <div class="modal fade" id="editModal{{ $subject->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form class="modal-content" action="{{ route('admin.subject.update', $subject->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Mapel</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nama Mapel</label>
                                        <input type="text" name="nama_mapel" class="form-control"
                                            value="{{ $subject->nama_mapel }}" required>
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
            <form class="modal-content" action="{{ route('admin.subject.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Mapel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Mapel</label>
                        <input type="text" name="nama_mapel" class="form-control" required>
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
            $('#subjectTable').DataTable();
        });
    </script>
@endsection
