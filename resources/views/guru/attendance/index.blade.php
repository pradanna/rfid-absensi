@extends('guru.base') {{-- base layout untuk guru --}}
@section('content')
    <div class="p-4">
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <input type="date" name="date" value="{{ $filters['date'] ?? '' }}" class="form-control"
                    placeholder="Tanggal" />
            </div>
            <div class="col-md-3">
                <select name="class_id" class="form-select">
                    <option value="">Semua Kelas</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}"
                            {{ ($filters['class_id'] ?? '') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="subject_id" class="form-select">
                    <option value="">Semua Mapel</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}"
                            {{ ($filters['subject_id'] ?? '') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->nama_mapel }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary w-100" type="submit">
                    <i class="bi bi-filter"></i> Filter
                </button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Mapel</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Terlambat?</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $att)
                        <tr>
                            <td>{{ $att->student->name }}</td>
                            <td>{{ $att->scheduleSubject->classroom->name ?? '-' }}</td>
                            <td>{{ $att->scheduleSubject->subject->nama_mapel ?? '-' }}</td>
                            <td>{{ $att->date }}</td>
                            <td>{{ $att->time_in }}</td>
                            <td class="{{ $att->is_late ? 'bg-danger bg-opacity-25 rounded' : '' }}">
                                {{ $att->is_late ? 'Ya' : 'Tidak' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $attendances->links() }}
        </div>
    </div>
@endsection
