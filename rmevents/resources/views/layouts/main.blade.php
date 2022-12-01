<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
    

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="/js/script.js"></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="collapse navbar-collapse" id="navbar">
                        <a href="/" class="navbar-brand">
                            <img src="/img/M2.svg" alt="RM Events">
                        </a>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/">Eventos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/events/create">Cria Eventos</a>
                            </li>
                            @auth
                            <li class="nav-item">
                                <a class="nav-link" href="/dashboard">Meus Eventos</a>
                            </li>
                            <li class="nav-item">
                                <form action="/logout" method="POST">
                                    @csrf
                                    <a href="/logout" class="nav-link" onclick="event.preventDefault(); this.closest('form').submit();">Sair</a>
                                </form>
                            </li>
                            @endauth
                            @guest
                            <li class="nav-item">
                                <a class="nav-link" href="/login">Entrar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/register">Cadastrar</a>
                            </li>
                            @endguest
                        </ul>
                    </div>
                </div>
        </nav>
    </header>
    <main>
        <div class="container-fluid">
            <div class="row">
                @if(session('msg'))
                <p class="msg">{{session('msg')}}</p>
                @endif
                @yield('content')
            </div>
        </div>
    </main>
    <footer>
        <p>RM Events &copy; 2022. Todos os direitos reservados.</p>
        <a href="https://github.com/RobersonMariani" class="navbar-brand" target="_blank">Desenvolvido por Roberson G. Mariani</a>
    </footer>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>