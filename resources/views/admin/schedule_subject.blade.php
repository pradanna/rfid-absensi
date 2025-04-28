@extends('admin.base')

@section('content')
    <div class="dashboard">
        <div class="menu-container">
            <div class="menu overflow-hidden">
                <div class="title-container">
                    <p class="title">Schedule Subject</p>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Data Jadwal Pelajaran</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Jadwal</button>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-striped" id="scheduleTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mata Pelajaran</th>
                            <th>Guru</th>
                            <th>Kelas</th>
                            <th>Hari</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schedules as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->subject->nama_mapel }}</td>
                                <td>{{ $item->teacher->name }}</td>
                                <td>{{ $item->classRoom->name }}</td>
                                <td>{{ daysOfWeek()[$item->day] ?? '-' }}</td>
                                <td>{{ $item->time_in }}</td>
                                <td>{{ $item->time_out }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $item->id }}">Edit</button>
                                    <form action="{{ route('admin.schedule.destroy', $item->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Edit Modal --}}
                @foreach ($schedules as $item)
                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form class="modal-content" method="POST"
                                action="{{ route('admin.schedule.update', $item->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Jadwal</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Mata Pelajaran</label>
                                        <select class="form-control" name="subject_id" required>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}"
                                                    {{ $item->subject_id == $subject->id ? 'selected' : '' }}>
                                                    {{ $subject->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Guru</label>
                                        <select class="form-control" name="teacher_id" required>
                                            @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->id }}"
                                                    {{ $item->teacher_id == $teacher->id ? 'selected' : '' }}>
                                                    {{ $teacher->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Kelas</label>
                                        <select class="form-control" name="class_id" required>
                                            @foreach ($classes as $classRoom)
                                                <option value="{{ $classRoom->id }}"
                                                    {{ $item->class_id == $classRoom->id ? 'selected' : '' }}>
                                                    {{ $classRoom->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Hari</label>
                                        <select class="form-control" name="day" required>
                                            @foreach (daysOfWeek() as $key => $day)
                                                <option value="{{ $key }}"
                                                    {{ $item->day == $key ? 'selected' : '' }}>
                                                    {{ $day }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Jam Masuk</label>
                                        <input type="time" class="form-control" name="time_in"
                                            value="{{ $item->time_in }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Jam Keluar</label>
                                        <input type="time" class="form-control" name="time_out"
                                            value="{{ $item->time_out }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    {{-- Create Modal --}}
    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="{{ route('admin.schedule.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Mata Pelajaran</label>
                        <select class="form-control" name="subject_id" required>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Guru</label>
                        <select class="form-control" name="teacher_id" required>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Kelas</label>
                        <select class="form-control" name="class_id" required>
                            @foreach ($classes as $classRoom)
                                <option value="{{ $classRoom->id }}">{{ $classRoom->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Hari</label>
                        <select class="form-control" name="day" required>
                            @foreach (daysOfWeek() as $key => $day)
                                <option value="{{ $key }}">{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Jam Masuk</label>
                        <input type="time" class="form-control" name="time_in" required>
                    </div>
                    <div class="mb-3">
                        <label>Jam Keluar</label>
                        <input type="time" class="form-control" name="time_out" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Tambah</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('morejs')
    <script>
        $(document).ready(function() {
            $('#scheduleTable').DataTable();
        });
    </script>
@endsection
