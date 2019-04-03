@php
use \App\Http\Controllers\Helper;
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>CORE-SP | {{ $title }}</title>
        <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/ico" />

        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/site.css') }}" rel="stylesheet">
    </head>
    <body>

    <!-- ACESSIBILIDADE -->
    <a href="#header-principal" accesskey="1"></a>
    <a href="#banner-principal" accesskey="3"></a>
    <a href="#rodape" accesskey="4"></a>
    <a id="accesskeyContraste" accesskey="5"></a>

      @section('header')
      <header id="header-principal">
        <div class="container-fluid">
          <div class="row">
            <div class="linha-verde w-100"></div>
          </div>
        </div>
        <div class="container">
          <div class="row mb-4 mt-4">
            <div class="col-sm-4 text-left">
                <a href="/"><img src="{{ asset('img/logo-certo.png') }}" alt="CORE-SP" id="logo-header" /></a>
            </div>
            <div class="col-sm-5 align-self-center">
              <div class="w-75 m-auto text-center">
                <div class="acessibilidade mb-2">
                  <button type="button" class="btn btn-sm btn-light" id="btn-contrast">
                    <i class="fas fa-adjust"></i>
                  </button>
                  <a href="/mapa-do-site">
                    <button type="button" class="btn btn-sm btn-light">
                      <i class="fas fa-map-marker-alt"></i>
                    </button>
                  </a>
                  <a href="/acessibilidade">
                    <button type="button" class="btn btn-sm btn-light">
                      <i class="fas fa-wheelchair"></i>
                    </button>
                  </a>
                </div>
                <form class="input-group input-group-sm"
                  method="GET"
                  role="form"
                  action ="/busca" />
                  <input type="text"
                    name="q"
                    class="form-control float-right"
                    placeholder="Digite o que você procura"
                    accesskey="2" />
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-sm-3 text-right align-self-center">
              <div class="mb-2">
                <button class="btn-atendimento d-inline"><h5 class="light branco">Atendimento: <strong>(11) 3243-5500</strong></h5></button>
              </div>
              <div class="sociais">
                <img src="{{ asset('img/002-whatsapp.png') }}" />
                <img src="{{ asset('img/001-youtube.png') }}" />
                <img src="{{ asset('img/icon-transparencia.png') }}" />
              </div>
            </div>
          </div>
        </div>
        <div class="container-fluid">
          <div class="row">
            <div class="linha-cinza"></div>
          </div>
        </div>
        <div class="container">
          <div class="row" id="menu-principal">
            <nav class="menu-principal m-auto">
              <ul class="nomargin nopadding">
                <li class="nav-item">
                  <a href="/" class="nav-link">Home</a>
                </li>
                <li class="nav-item dropdown">
                  <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown">CORE-SP</a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a href="/legislacao" class="dropdown-item">Legislação</a>
                  </div>
                </li>
                <li class="nav-item">
                  <a href="http://core-sp.implanta.net.br/portaltransparencia/#publico/inicio" class="nav-link" target="_blank">Transparência</a>
                </li>
                <li class="nav-item">
                  <a href="/licitacoes" class="nav-link">Licitações</a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">Seccionais</a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">E-OUV</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </header>

      <header id="fixed-menu" class="pb-2">
        <div class="container">
          <img src="{{ asset('img/brasao.png') }}" />
          <div class="row" id="append-menu">
            
          </div>
        </div>
      </header>
      @show

      @yield('content')

      @section('footer')
      <div class="linha-verde"></div>
      <footer class="pt-4" id="rodape">
        <div class="container mb-4">
          <div class="row">
            <div class="col-4">
              <div class="footer-title w-75 mb-3">
                <h5 class="branco">Localização</h5>
              </div>
              <p class="branco mb-1">
                Rua Brigadeiro Luís Antônio, 613
                <br />Térreo - CEP: 01317-000
                <br />São Paulo - SP
                <br />CNPJ: 60.746.179/0001-52
              </p>
              <div class="footer-title w-75 mb-3 mt-4">
                <h5 class="branco">Contato</h5>
              </div>
              <p class="branco mb-1">
                <strong>E-mail:</strong>
                <br />atendimento@core-sp.org.br
              </p>
              <p class="branco">
                <strong>Telefone:</strong>
                <br />(11) 3243-5500
              </p>
            </div>
            <div class="col-4">
              <div class="footer-title w-75 mb-3">
                <h5 class="branco">Serviços</h5>
              </div>
              <p class="branco"><a href="http://core-sp.implanta.net.br/portaltransparencia/#publico/inicio" target="_blank">Transparência</a></p>
              <p class="branco"><a href="#">Links Úteis</a></p>
              <p class="branco"><a href="/licitacoes">Licitações</a></p>
              <p class="branco"><a href="#">Concursos</a></p>
              <p class="branco"><a href="#">Agenda Core-SP</a></p>
              <p class="branco"><a href="/cursos">Cursos</a></p>
              <p class="branco"><a href="#">Feiras</a></p>
              <p class="branco"><a href="/balcao-de-oportunidades">Balcão de Oportunidades</a></p>
              <p class="branco"><a href="#">Simulador de Cálculos</a></p>
              <p class="branco"><a href="#">Registre-se</a></p>
              <p class="branco"><a href="#">E-OUV</a></p>
              <p class="branco"><a href="#">Seccionais</a></p>
            </div>
            <div class="col-4">
              <div class="footer-title w-75 mb-3">
                <h5 class="branco">Newsletter</h5>
              </div>
              <div class="w-75">
                <p class="branco">Inscreva-se para receber nossos informativos:</p>
                <form class="mt-3" id="newsletter">
                  <div class="form-group">
                    <input type="text" name="nome" class="form-control" placeholder="Nome" />
                  </div>
                  <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="E-mail" />
                  </div>
                  <div class="form-group">
                    <input type="text" name="celular" class="form-control" placeholder="Celular" />
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-default">Inscrever-se</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="linha-azul w-100"></div>
        <div class="linha-branca w-100"></div>
        <div class="linha-azul-escuro w-100"></div>
      </footer>
      @show

      <script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>
      <script type="text/javascript" src="{{ asset('/js/site.js') }}"></script>
      <script type="text/javascript" src="{{ asset('/js/acessibilidade.js') }}"></script>
    </body>
</html>
