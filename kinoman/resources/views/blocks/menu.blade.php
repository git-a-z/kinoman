<header class="flex sp_btw header">
    <nav class="flex header_navigation">
        <div class="header_logo">
            <img src="/img/logo.svg" alt="logo" class="header_logo_img">
            <p class="header_logo_p">Киноман</p>
        </div>
        <ul class="flex sp_btw header_navigation_list">
            <li><a href="{{route('catalog')}}">Каталог</a></li>
            <li><a href="{{route('collections')}}">Коллекции</a></li>
            <li><a href="{{route('home')}}">🏠</a></li>
        </ul>
    </nav>
    <div class="flex sp_btw header_blocks">
        <a href="{{route('search')}}" class="flex header_blocks_search">
            <svg
                width="32"
                height="29"
                viewBox="0 0 50 50"
                xmlns="http://www.w3.org/2000/svg"
                class="header_blocks_img"
            >
                <path
                    d="M48.8574 43.3301L37.168 31.6406C39.8262 27.6944 41.1377 22.7637 40.4356 17.5098C39.2383 8.57327 31.9141 1.30081 22.9688 0.168289C9.66895 -1.51462 -1.51464 9.66897 0.168369 22.9688C1.30118 31.918 8.57462 39.2481 17.5121 40.4395C22.766 41.1415 27.6977 39.8305 31.643 37.1719L43.3324 48.8613C44.8578 50.3867 47.3314 50.3867 48.8568 48.8613C50.3809 47.334 50.3809 44.8535 48.8574 43.3301ZM7.72462 20.3125C7.72462 13.4199 13.332 7.81253 20.2246 7.81253C27.1172 7.81253 32.7246 13.4199 32.7246 20.3125C32.7246 27.2051 27.1172 32.8125 20.2246 32.8125C13.332 32.8125 7.72462 27.2071 7.72462 20.3125Z"
                />
            </svg>
            Поиск
        </a>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">
                        </ul>
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('profile') }}">
                                            Профиль
                                        </a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
