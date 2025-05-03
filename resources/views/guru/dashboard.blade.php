@extends('guru.base')

@section('content')
    <div class="dashboard">
        {{-- STATUS --}}
        <div class="status-container icon-circle">
            <a class="card-status color1" href="#">
                <div class="content">
                    <div class="stat">
                        <p class="title">Jumlah Siswa</p>
                        <p class="val" id="totalSiswa">{{ $jumlahSiswa }}</p>
                    </div>
                    <div class="report">
                        <p><span class="down">{{ $jumlahSiswa }}</span> siswa yang Anda ajar.</p>
                    </div>
                </div>
                <div class="icon-container">
                    <span class="material-symbols-outlined">group</span>
                </div>
            </a>

            <a class="card-status color2" href="#">
                <div class="content">
                    <div class="stat">
                        <p class="title">Jadwal Hari Ini</p>
                        <p class="val" id="jadwalHariIni">{{ $jumlahJadwalHariIni }}</p>
                    </div>
                    <div class="report">
                        <p><span class="down">{{ $jumlahJadwalHariIni }}</span> jadwal Anda hari ini.</p>
                    </div>
                </div>
                <div class="icon-container">
                    <span class="material-symbols-outlined">event</span>
                </div>
            </a>

            {{-- <a class="card-status color4" href="#">
                <div class="content">
                    <div class="stat">
                        <p class="title">Siswa Sudah Absen</p>
                        <p class="val" id="siswaAbsen">{{ $jumlahAbsensiHariIni }}</p>
                    </div>
                    <div class="report">
                        <p><span class="down">{{ $jumlahAbsensiHariIni }}</span> siswa absen hari ini.</p>
                    </div>
                </div>
                <div class="icon-container">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
            </a> --}}
        </div>

        <!-- Tabel Absensi Hari Ini -->
        <div class="mt-5">
            <h2>Jadwal Anda Hari Ini</h2>

            <table id="jadwalTable" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Jam Masuk</th>
                        <th>Jam Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jadwalHariIni as $jadwal)
                        <tr>
                            <td>{{ $jadwal->classRoom->name ?? 'N/A' }}</td>
                            <td>{{ $jadwal->subject->nama_mapel ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($jadwal->time_in)->format('H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($jadwal->time_out)->format('H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection

@section('morejs')
    <script>
        $(document).ready(function() {
            $('#attendanceTable').DataTable();
        });
    </script>
@endsection
