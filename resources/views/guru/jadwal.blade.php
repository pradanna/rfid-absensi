@extends('guru.base')

@section('content')
    <div class="dashboard">
        @php
            $hariIndo = [
                1 => 'Senin',
                2 => 'Selasa',
                3 => 'Rabu',
                4 => 'Kamis',
                5 => 'Jumat',
                6 => 'Sabtu',
                7 => 'Minggu',
            ];
        @endphp

        @foreach ($hariIndo as $day => $namaHari)
            <div class="mt-6">
                <h3>{{ $namaHari }}</h3>
                <table class="table w-full" id="jadwalTable{{ $day }}">
                    <thead>
                        <tr>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Jam Masuk</th>
                            <th>Jam Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jadwalPerHari[$day] as $jadwal)
                            <tr>
                                <td>{{ $jadwal->classRoom->name ?? 'N/A' }}</td>
                                <td>{{ $jadwal->subject->nama_mapel ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($jadwal->time_in)->format('H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($jadwal->time_out)->format('H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada jadwal</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endforeach


    </div>
@endsection

@section('morejs')
    <script>
        $(document).ready(function() {
            $('#attendanceTable').DataTable();
        });
    </script>
@endsection
