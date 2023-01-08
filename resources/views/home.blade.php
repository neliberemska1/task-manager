<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tasks Manager</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="antialiased">
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" >
            <div class="container">
                <a class="navbar-brand" href="#">Tasks Manager</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <router-link class="nav-link" to="/">Home</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/tasks">All Tasks</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/mytasks">My Tasks</router-link>
                        </li>

                    </ul>
                    <ul class="navbar-nav float-end mb-2 mb-lg-0">
                        <li class="nav-item disabled">
                            <a class="nav-link" href="#">
                                <strong>{{ Auth::user()->name }}</strong>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('logout')}}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout</a>
                            <form id="logout-form" action="{{route('logout')}}" method="POST">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-4">
            <router-view></router-view>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>