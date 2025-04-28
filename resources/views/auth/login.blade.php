<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="shortcut icon" href="{{ asset('images/local/favicon.ico') }}" title="Favicon" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-genosstyle.v.02.css') }}" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ asset('/css/sweetalert2.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/sweetalert2.min.js') }}"></script>
    <style>
        body {
            font-family: 'Nunito';
        }
    </style>
</head>

<body class="w-100 h-100 bg-login">
    <div style="height: 100vh">
        @if (\Illuminate\Support\Facades\Session::has('failed'))
            <script>
                Swal.fire("Autentikasi Gagal ", 'Periksa Username dan Password!', "error")
            </script>
        @endif
        <div class="login">
            <div class="panel-login pinggiran-bunder-10  ">

                <div class="gambar">
                    <img src={{ asset('images/local/login.jpg') }} />
                </div>

                <div class="login-container">
                    <div>
                        <p class="text-center mt-3 h2 fw-bold">Hello Again!</p>
                        <p class="text-center mt-3  fw-bold">Masukan Username dan Password</p>

                        <form class="p-3" method="POST" action="/login">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control login" id="username" name="username"
                                    value="{{ old('username') }}">
                                @if ($errors->has('username'))
                                    <p class="text-danger" style="font-size: 0.8em">
                                        {{ $errors->first('username') }}
                                    </p>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control login" id="password" name="password">
                                @if ($errors->has('password'))
                                    <p class="text-danger" style="font-size: 0.8em">
                                        {{ $errors->first('password') }}
                                    </p>
                                @endif
                            </div>
                            <button class="btn-login   mt-4 d-block mb-3 w-100 " type="submit">LOGIN
                            </button>

                            <span class="d-block  text-center ">Bila ada kendala dalam login akun, silahkan hubungi
                                <a href="#">admin</a></span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ dump($errors) }}

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
</body>

</html>
