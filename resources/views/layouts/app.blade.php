<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $site_title }}</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
</head>
<body>
    <div class="container flex justify-around align-items-center gap-3">
        <h1>{{ $site_title }}</h1>
        @session('success')
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endsession
        <div>
            @yield('content')
        </div>
    </div>
</body>
</html>
