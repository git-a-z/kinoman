<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/movie.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
</head>
<body>
    
        @include('blocks.menu')
        
    
    <!-- <main class="content container"> -->
        <h1>
            <!-- @yield('pageName') -->
        </h1>
        @yield('content')
    <!-- </main> -->

    @include('blocks.footer')
  
</body>
</html>
