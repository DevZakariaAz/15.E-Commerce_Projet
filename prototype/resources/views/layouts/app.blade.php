<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ0000vvM3y5gQk1f+jgD8t3OxaD6yYb4pLfXjjXktw6F2ZsA7iQ5Nw0HqBf" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        /* Customizing dropdown items */
        .dropdown-menu {
            min-width: 250px;
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        .dropdown-item:focus, .dropdown-item:active {
            background-color: #e9ecef;
        }
        .user-header i {
            font-size: 40px;
        }
        .user-footer .btn {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                
                <a class="navbar-brand" href="{{ url('/home') }}">
                    Home
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
@if (Route::has('login'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">
            <i class="bi bi-person-circle"></i> Login <!-- Displaying the icon and login text -->
        </a>
    </li>
@endif

@if (Route::has('register'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}">
            <i class="bi bi-person-plus"></i> Register <!-- Displaying the icon and register text -->
        </a>
    </li>
@endif
                        @else
                            <li class="nav-item dropdown user-menu">
                                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                  <i class="bi bi-person-circle"></i> <!-- Profile Icon -->
                                  <span class="d-none d-md-inline">{{ auth()->user()->name }}</span> <!-- Display user name -->
                                </a>
                                
                                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <!-- User Header -->
                                    <li class="user-header text-bg-primary">
                                        <i class="bi bi-person-circle"></i> <!-- Profile Icon in the header -->
                                        <p>
                                          {{ auth()->user()->name }} <!-- User Name -->
                                          <small>Member since {{ auth()->user()->created_at->format('M Y') }}</small> <!-- Membership Date -->
                                        </p>
                                    </li>
                                    <!-- User Footer -->
                                    <li class="user-footer">
                                        <a href="" class="btn btn-default btn-flat">Profile</a> <!-- Profile Link -->
                                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-default btn-flat float-end">Sign out</button> <!-- Logout Button -->
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS Bundle (Includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8Fq/4p9G+r59P5E+g13Yz5Z56u6JlkkkYw5x6Qg+aGb8w5" crossorigin="anonymous"></script>
</body>
</html>
