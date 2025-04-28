<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin || Genos Template</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />


    {{-- BOOTSTRAP --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    {{-- CSS --}}
    <link href="{{ asset('css/admin-genosstyle.v.02.css') }}" rel="stylesheet" />

    {{-- FONT --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,700&display=swap"
        rel="stylesheet">

    {{-- DATA TABLES --}}
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" />


    {{-- ICON --}}
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />


    {{-- SWEEET ALERT --}}
    {{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.4/dist/sweetalert2.min.css" --}}
    {{--          integrity="sha256-h2Gkn+H33lnKlQTNntQyLXMWq7/9XI2rlPCsLsVcUBs=" crossorigin="anonymous"> --}}
    <script src="{{ asset('js/swal.js') }}"></script>
    {{--    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script> --}}
    <link href="{{ asset('js/dropify/css/dropify.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">


    @yield('morecss')

</head>

<body>

    <div class="d-flex admin ">
        {{-- SIDEBAR --}}
        <div class="sidebar ">
            <div class="logo-container">
                <img class="company-logos" src="{{ asset('images/local/logo-panjang.png') }}" />
                <img class="company-logos-minimize" src="{{ asset('images/local/logo-pendek.png') }}" />
            </div>
            <div class="menu-container">

                <ul>
                    <li>
                        <a class=" menu {{ Request::is('admin') ? 'active' : '' }} tooltip" href="/admin"><span
                                class="material-symbols-outlined">
                                dashboard
                            </span>
                            <span class="text-menu"> Beranda</span>
                            <span class="tooltiptext">Beranda</span>
                        </a>
                    </li>


                    <li>
                        <a class="menu tooltip {{ Request::is('admin/profile') ? 'active' : '' }}"
                            href="/admin/profile"><span class="material-symbols-outlined">
                                account_circle
                            </span>
                            <span class="text-menu"> Profile</span>
                            <span class="tooltiptext">Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu tooltip {{ Request::is('admin/service') ? 'active' : '' }}"
                            href="/admin/service">


                            <span class="material-symbols-outlined">
                                home_repair_service
                            </span>
                            <span class="text-menu"> Service</span>
                            <span class="tooltiptext">Service</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu tooltip {{ Request::is('admin/artikel') ? 'active' : '' }}"
                            href="/admin/artikel">

                            <span class="material-symbols-outlined">
                                newsmode
                            </span>
                            <span class="text-menu"> Artikel</span>
                            <span class="tooltiptext">Artikel</span>
                        </a>
                    </li>





                    <li>
                        <a class="menu tooltip {{ Request::is('admin/portfolio') ? 'active' : '' }}"
                            href="/admin/portfolio">


                            <span class="material-symbols-outlined">
                                work_history
                            </span>
                            <span class="text-menu"> Portfolio</span>
                            <span class="tooltiptext">Portfolio</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu tooltip {{ Request::is('admin/clients') ? 'active' : '' }}"
                            href="/admin/clients">


                            <span class="material-symbols-outlined">
                                group
                            </span>
                            <span class="text-menu"> Clients</span>
                            <span class="tooltiptext">Clients</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu tooltip {{ Request::is('admin/testimoni') ? 'active' : '' }}"
                            href="/admin/testimoni">

                            <span class="material-symbols-outlined">
                                forum
                            </span>
                            <span class="text-menu"> Testimoni</span>
                            <span class="tooltiptext">Testimoni</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu tooltip {{ Request::is('admin/about') ? 'active' : '' }}" href="/admin/about">


                            <span class="material-symbols-outlined">
                                info
                            </span>
                            <span class="text-menu"> About</span>
                            <span class="tooltiptext">About</span>
                        </a>
                    </li>
                </ul>

                <div class="footer">
                    <p class="top">Login Sebagai</p>
                    <p class="bot">Admin</p>
                </div>
            </div>
        </div>


        {{-- BODY --}}
        <div class="gen-body  ">

            {{-- BOTTOMBAR --}}
            <div class="bottombar">
                <a href="/admin/dashboard" class="nav-button {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <span class="material-symbols-outlined ">
                        dashboard
                    </span>
                    <span class="text-menu"> Beranda</span>
                </a>
                <a href="/admin/datatitik" class="nav-button {{ Request::is('admin/datatitik') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">
                        desktop_windows
                    </span>
                    <span class="text-menu"> Data Titik</span>
                </a>

                <a href="/admin/profile" class="nav-button {{ Request::is('admin/profile') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">
                        account_circle
                    </span>
                    <span class="text-menu"> Profile</span>
                </a>

            </div>

            {{-- NAVBAR --}}
            <div class="gen-nav">
                <div class="start">
                    <a class="nav-button">
                        <span class="iconfwd material-symbols-outlined">
                            arrow_forward
                        </span>
                        <span class="iconback material-symbols-outlined">
                            arrow_back
                        </span>
                    </a>
                </div>
                <div class="end">
                    <a class="iconbtn " id="dropdownnotif" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="badges">
                        </span>
                        <span class="material-symbols-outlined">
                            mail
                        </span>

                    </a>
                    <div class="dropdown-menu menudropdown notif" aria-labelledby="dropdownnotif">
                        <div class="title-container">
                            <p class="title">Notification</p>
                            <a class="action"> Clear All</a>
                        </div>
                        <hr>
                        <div class="notif-container" id="notif">
                            {{-- <div class="notif-item unread"> --}}
                            {{--                                                    <div class="content-container"> --}}
                            {{--                                                        <p class="title-content">Bagus Want to buy something </p> --}}
                            {{--                                                        <p class="body-content">You Have new transaction from bagus yanuar, please check! --}}
                            {{--                                                        </p> --}}
                            {{--                                                    </div> --}}
                            {{--                                                    <hr> --}}

                            {{-- </div> --}}
                            {{--                                                <div class="notif-item"> --}}

                            {{--                                                    <div class="content-container"> --}}
                            {{--                                                        <p class="title-content">Bagus Want to buy something </p> --}}
                            {{--                                                        <p class="body-content">You Have new transaction from bagus yanuar, please check! --}}
                            {{--                                                        </p> --}}
                            {{--                                                    </div> --}}
                            {{--                                                    <hr> --}}

                            {{--                                                </div> --}}
                        </div>
                        <hr>
                        <div class="footer-container"><a href="/admin/inbox">See All Notifications</a></div>
                    </div>
                    <div class="dropdown">
                        <div class="profile-button">
                            <div class="content">

                                <a id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('images/local/account.jpg') }}" />
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <p class="user">User</p>
                                    <p class="email">user@gmail.com</p>
                                    <hr>
                                    <a class="logout" href="/logout">Logout</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CONTENT --}}
            <div class="gen-content">
                @yield('content')
            </div>

            <div class="bottom-mobile">

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    {{--    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.4/dist/sweetalert2.all.min.js" --}}
    {{--            integrity="sha256-SrfCZ78qS4YeGNB8awBuKLepMKtLR86uP4oomyg4pUc=" crossorigin="anonymous"></script> --}}
    <script type="text/javascript" src="{{ asset('js/debounce.js') }}"></script>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="{{ asset('js/admin-genosstyle.js') }}"></script>
    <script src="{{ asset('js/dialog.js') }}"></script>
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="{{ asset('js/dropify/js/dropify.js') }}"></script>

    <script>
        getAjaxResNotif()

        function getAjaxResNotif() {
            let notif = $('#notif')
            // notif.empty()
            $.get('{{ route('admin.dashboard.inbox.notif') }}', function(res, x, s) {
                if (s.status == 200) {
                    $.each(res, function(k, v) {
                        let stat = v.isNew ? 'unread' : ''
                        notif.append('<div class="notif-item ' + stat + '">' +
                            '<div class="content-container">' +
                            ' <p class="title-content">' + v.name + '</p>' +
                            ' <p class="body-content maxlines">' + v.message + '</p>' +
                            ' </div>' +
                            ' <hr>' +
                            '</div>');
                    })
                }
            })
        }

        jQuery.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": oSettings._iDisplayLength === -1 ?
                    0 : Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": oSettings._iDisplayLength === -1 ?
                    0 : Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };
    </script>
    @yield('morejs')
    <script type="text/javascript" src="{{ asset('js/debounceDefault.js') }}"></script>

</body>

</html>
