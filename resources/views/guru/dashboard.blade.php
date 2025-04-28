@extends('admin.base')

@section('content')
    <div class="dashboard">
        {{-- STATUS --}}
        <div class="status-container icon-circle">
            <a class="card-status color1" href="/admin/datatitik">
                <div class="content">
                    <div class="stat">
                        <p class="title">Jumlah Titik</p>
                        <p class="val" id="titikAll">0</p>
                    </div>

                    <div class="report">
                        <p><span class="down" id="titikPublic">0</span> Jumlah titik yang ditampilkan untuk public.</p>
                    </div>
                </div>

                <div class="icon-container">
                    <span class="material-symbols-outlined">
                        assignment
                    </span>
                </div>
            </a>

            <a class="card-status color2" href="/admin/datatitik">
                <div class="content">
                    <div class="stat">
                        <p class="title">Jumlah Artikel</p>
                        <p class="val article">0</p>
                    </div>

                    <div class="report">
                        <p><span class="down article">0</span> Jumlah artikel.</p>
                    </div>
                </div>

                <div class="icon-container">
                    <span class="material-symbols-outlined">
                        event_available
                    </span>
                </div>
            </a>

            <a class="card-status color3" href="/admin/datatitik">
                <div class="content">
                    <div class="stat">
                        <p class="title">Jumlah Portfolio</p>
                        <p class="val porto">0</p>
                    </div>

                    <div class="report">
                        <p><span class="down porto">0</span> Titik portfolio.</p>
                    </div>
                </div>

                <div class="icon-container">
                    <span class="material-symbols-outlined">
                        cast
                    </span>
                </div>
            </a>


        </div>

        {{-- Titik disewa --}}
        <div class="menu-container  ">
            <div class="menu overflow-hidden">
                <div class="title-container">
                    <p class="title">Inbox</p>
                </div>
                <table id="tabel" class="table table-striped nowrap " style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Nomor Whatsapp</th>
                            <th>Pesan</th>
                            <th style="width: 100px">Action</th>
                            {{-- detail, ubah status pesanan --}}
                        </tr>
                    </thead>
                    {{--                    <tbody> --}}
                    {{--                    <tr> --}}
                    {{--                        <td>Bagus</td> --}}
                    {{--                        <td>0895178657</td> --}}
                    {{--                        <td>Halo, saya mau pasang billboard untuk kota Solo 20 titik, gimana caranya ?</td> --}}
                    {{--                        <td> --}}
                    {{--                            <span class="d-flex gap-1"> --}}
                    {{--                                <a class="btn-primary-sm" data-bs-toggle="modal" --}}
                    {{--                                   data-bs-target="#modaldetail">Whatsapp</a> --}}
                    {{--                                    <a class="btn-warning-sm" data-bs-toggle="modal" --}}
                    {{--                                       data-bs-target="#modalubahpesanan">Hapus</a> --}}
                    {{--                                </span> --}}
                    {{--                        </td> --}}
                    {{--                    </tr> --}}

                    {{--                    </tbody> --}}
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Nomor Whatsapp</th>
                            <th>Pesan</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>

            </div>

        </div>
    </div>
@endsection

@section('morejs')
    <script script>
        $(document).ready(function() {
            getAjaxRes('{{ route('admin.dashboard.titik') }}', $('#titikAll'), 'titik')
            getAjaxRes('{{ route('admin.dashboard.titik.public') }}', $('#titikPublic'), 'titik')
            getAjaxRes('{{ route('admin.dashboard.article') }}', $('.article'), 'article')
            getAjaxRes('{{ route('admin.dashboard.portfolio') }}', $('.porto'), 'porto')
        })

        function getAjaxRes(url, content, variable) {
            $.get(url, function(res, x, s) {
                if (s.status == 200) {
                    content.html(res[variable].toLocaleString())
                }
            })
        }


        show_datatable();

        function show_datatable() {
            let colums = [{
                    className: "text-center",
                    orderable: false,
                    defaultContent: "",
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'phone',
                    name: 'phone',
                },
                {
                    data: 'message',
                    name: 'message',
                    render: function(data) {
                        return '<span class="maxlines">' + data + '</span>'
                    }
                },
                {
                    className: "text-center",
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data, x, row) {
                        let picPhone = row.phone;
                        const first = picPhone.substring(0, 1);
                        if (first == 0) {
                            picPhone = '62' + picPhone.substring(1)
                        }
                        return '<span class="d-flex gap-1">' +
                            ' <a class="btn-primary-sm" ' +
                            '  target="_blank" href="https://wa.me/' + picPhone + '">Whatsapp</a>' +
                            ' <a class="btn-warning-sm" id="deleteInbox" data-name="' + row.name + '" data-id="' +
                            data + '" >Hapus</a>' +
                            '</span>';
                    }
                },
            ];
            datatable('tabel', '{{ route('admin.dashboard.inbox.datatable') }}', colums)
        }

        $(document).on('click', '#deleteInbox', function() {
            let form = {
                '_token': '{{ csrf_token() }}',
                'id': $(this).data('id')
            }
            deleteData('message ' + $(this).data('name'), form, '{{ route('admin.dashboard.inbox.delete') }}',
                afterDelete)
            return false
        })

        function afterDelete() {
            $('#tabel').DataTable().ajax.reload(null, false);
        }
    </script>
@endsection
