<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
</head>
<body>
    <div class="header">
        @include('blocks.menu')
        <hr>
    </div>
    <div class="content">
        <h1>
            @yield('pageName')
        </h1>
        @yield('content')
    </div>
    <div class="footer">
        <hr>
        <p>footer</p>
    </div>
</body>
</html>
