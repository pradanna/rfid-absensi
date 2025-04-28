@extends('admin.base')

@section('content')
    <div class="dashboard">
        {{-- STATUS --}}
        <div class="status-container icon-circle">
            <a class="card-status color1" href="/admin/siswa">
                <div class="content">
                    <div class="stat">
                        <p class="title">Jumlah Siswa</p>
                        <p class="val" id="totalSiswa">0</p>
                    </div>
                    <div class="report">
                        <p><span class="down" id="siswaAktif">0</span> siswa aktif terdaftar.</p>
                    </div>
                </div>
                <div class="icon-container">
                    <span class="material-symbols-outlined">group</span>
                </div>
            </a>

            <a class="card-status color2" href="/admin/classroom">
                <div class="content">
                    <div class="stat">
                        <p class="title">Jumlah Kelas</p>
                        <p class="val" id="totalKelas">0</p>
                    </div>
                    <div class="report">
                        <p><span class="down" id="kelasAktif">0</span> kelas aktif.</p>
                    </div>
                </div>
                <div class="icon-container">
                    <span class="material-symbols-outlined">home_work</span>
                </div>
            </a>

            <a class="card-status color3" href="/admin/jadwal">
                <div class="content">
                    <div class="stat">
                        <p class="title">Jadwal Hari Ini</p>
                        <p class="val" id="jadwalHariIni">0</p>
                    </div>
                    <div class="report">
                        <p><span class="down" id="jadwalAktif">0</span> jadwal berjalan hari ini.</p>
                    </div>
                </div>
                <div class="icon-container">
                    <span class="material-symbols-outlined">event</span>
                </div>
            </a>

            <a class="card-status color4" href="/admin/absensi">
                <div class="content">
                    <div class="stat">
                        <p class="title">Siswa Sudah Absen</p>
                        <p class="val" id="siswaAbsen">0</p>
                    </div>
                    <div class="report">
                        <p><span class="down" id="siswaAbsenHariIni">0</span> siswa absen hari ini.</p>
                    </div>
                </div>
                <div class="icon-container">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
            </a>

        </div>
        <!-- Tabel Absensi Hari Ini -->
        <div class="mt-5">
            <h2>Absensi Hari Ini</h2>

            <!-- Tabel Absensi Hari Ini -->
            <table id="attendanceTable" class="table  " style="width:100%">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jam Masuk</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru</th>
                        <th>Waktu Masuk</th>
                        <th>Terlambat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->student->name }}</td>
                            <td>{{ $attendance->time_in->format('H:i:s') }}</td>
                            <td>
                                @if ($attendance->scheduleSubject && $attendance->scheduleSubject->classRoom)
                                    {{ $attendance->scheduleSubject->classRoom->name }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if ($attendance->scheduleSubject && $attendance->scheduleSubject->classRoom)
                                    {{ $attendance->scheduleSubject->subject->nama_mapel }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if ($attendance->scheduleSubject && $attendance->scheduleSubject->classRoom)
                                    {{ $attendance->scheduleSubject->teacher->name }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $attendance->time_in->format('H:i:s') }}</td>
                            <td>{{ $attendance->islate ? 'Yes' : 'No' }}</td>
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
