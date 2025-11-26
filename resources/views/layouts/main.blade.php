<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- BootStrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Fonts -->

    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="/css/style.css">

    <!-- JS -->
    <script src="/js/scripts.js"></script>
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="collapse navbar-collapse" id="navbar">
                <a href="" class="navbar-brand">
                    <img src="/img/logo.png" alt="KaryanDevs">
                </a>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="/" class="nav-link">Eventos</a>
                    </li>

                    <li class="nav-item">
                        <a href="/events/create" class="nav-link">Criar Evento</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link">Meus eventos</a>
                    </li>
                    <li class="nav-item">
                        <form action="/logout" method="POST">
                            @csrf
                            <a href="/logout" class="nav-link" onclick="event.preventDefault(); 
                            this.closest('form').submit();">Sair</a>
                        </form>
                    </li>
                    @endauth

                    @guest

                    <li class="nav-item">
                        <a href="/login" class="nav-link">Entrar</a>
                    </li>
                    <li class="nav-item">
                        <a href="/register" class="nav-link">Cadastrar</a>
                    </li>

                    @endguest
                </ul>
            </div>
        </nav>

    </header>

    <main>
        <div class="container-fluid">
            <div class="row">
                @if (session('msg'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('msg') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')

            </div>
        </div>
    </main>
    <footer>
        <div class="footer-links">
            <a href="/" id="link-footer">Home</a> 
            <a href="/contact">Contatos</a>
        </div>

        <p>Karyan The Pierrot &copy; 2025</p>
    </footer>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>