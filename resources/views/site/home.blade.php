@extends('site.layout.app', ['title' => 'Conselho Regional dos Representantes Comerciais no Estado do Espirito Santo'])

@section('description')
  <meta name="description" content="O Core-ES é responsável pela consulta, orientação, disciplina e fiscalização do exercício da profissão de Representação Comercial no estado do Espirito Santo.">
@endsection

@section('content')

<!-- Adiciona popup
@include('site.inc.popup') --> 

<section>
  <div class="container-fluid">
    <div class="row" id="conteudo-principal">
      <div id="carousel" class="carousel slide" data-ride="carousel" data-interval="6000">
        <ol class="carousel-indicators">
          @php $i = -1; @endphp
          @foreach($imagens as $img)
          @php $i++; @endphp
          @if(!empty($img->url))
            @if($i === 0)
              <li data-target="#carousel" data-slide-to="{{ $i }}" class="active"></li>
            @else
              <li data-target="#carousel" data-slide-to="{{ $i }}"></li>
            @endif
          @endif
          @endforeach
        </ol>
        <div class="carousel-inner h-100">
          @foreach($imagens as $img)
          @if(!empty($img->url))
            @if($img->ordem === 1)
            <div class="carousel-item h-100 active">
            @else
            <div class="carousel-item h-100">
            @endif
              <a href="{{ $img->link }}" target="{{ $img->target }}">
                <img class="w-100 hide-576" src="{{ asset($img->url) }}" alt="Core-ES | Conselho Regional dos Representantes Comercias no Estado do Espirito Santo" />
                <img class="w-100 show-576" src="{{ asset($img->url_mobile) }}" alt="Core-ES | Conselho Regional dos Representantes Comercias no Estado do Espirito Santo" />
              </a>
            </div>
          @endif
          @endforeach
        </div>
        <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </div>
</section>

<section id="home-news" class="mb-2 mt-4">
  <div class="container">
    <div class="row mb-2">
      <div class="col-12">
        <div class="home-title">
          <blockquote>
            <i></i>
            <h2 class="pr-3 ml-1">Notícias</h2>
          </blockquote>
          <h5 class="float-right branco-bg">
            <a href="{{ route('noticias.siteGrid') }}"><i class="fas fa-plus-circle icon-title"></i> Ver mais notícias</a>
          </h5>
        </div>
      </div>
    </div>
    <div class="row">
      @foreach($noticias as $noticia)
        @include('site.inc.noticia-grid')
      @endforeach
    </div>
  </div>
</section>

<section id="espaco-representante" class="mb-2">
  <div class="container">
    <div class="row mb-2">
      <div class="col-12">
        <div class="home-title">
          <blockquote>
            <i></i>
            <h2 class="pr-3 ml-1">Espaço do Representante</h2>
          </blockquote>
          <h5 class="float-right cinza-claro-bg">
          <a href="{{ route('representante.login') }}"><i class="fas fa-user icon-title"></i> Área restrita do Representante</a>
          </h5>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-3 col-sm-6 pb-15">
        <div class="box text-center azul-escuro-bg">
          <div class="inside-box">
            <img src="{{ asset('img/padlock.png') }}" class="inside-img" alt="Área restrita do Representante | Core-ES" />
            <h3 class="text-uppercase mt-3 branco light h3-box mb-3">Área restrita<br class="hide-992" /> do Representante</h3>
            <a href="/representante/login" class="d-block h-100">
              <button class="btn-box azul-escuro">Acessar</button>
            </a>
            <a href="/representante/cadastro" class="d-block h-100">
              <button class="btn-box btn-box-little azul-escuro">Cadastrar-se</button>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6 pb-15">
        <a href="/consulta-de-situacao" class="d-block">
          <div class="box text-center azul-bg">
            <div class="inside-box">
              <img src="{{ asset('img/file.png') }}" class="inside-img alt="Consulta de Ativos | Core-ES">
              <h3 class="text-uppercase mt-3 branco light h3-box mb-3">Consulta<br class="hide-992" /> de situação</h3>
              <button class="btn-box azul">Consultar</button>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-sm-6 pb-15">
        <div class="box text-center azul-escuro-bg">
          <div class="inside-box">
            <img src="{{ asset('img/001-work.png') }}" class="inside-img" alt="Balcão de Oportunidades | Core-ES" />
            <h3 class="text-uppercase mt-3 branco light h3-box mb-3">Balcão de<br class="hide-992" /> Oportunidades</h3>
            <a href="/balcao-de-oportunidades" class="d-inline h-100">
              <button class="btn-box azul-escuro">Acessar</button>
            </a>
            <a href="/anunciar-vaga" class="d-inline h-100">
              <button class="btn-box btn-box-little azul-escuro">Anunciar</button>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6 pb-15">
        <a href="/anuidade-ano-vigente" class="d-block h-100">
          <div class="box text-center azul-bg">
            <div class="inside-box">
              <img src="{{ asset('img/printer.png') }}" class="inside-img" alt="Anuidade do ano vigente | Core-ES" />
              <h3 class="text-uppercase mt-3 branco light h3-box mb-3">Boleto<br class="hide-992" /> anuidade {{ date('Y') }}</h3>
              <button class="btn-box azul">Acessar</button>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-sm-6 text-right pb-15">
        <a href="/simulador" class="d-block h-100">
          <div class="box text-center azul-bg">
            <div class="inside-box">
              <img src="{{ asset('img/001-paper.png') }}" class="inside-img" alt="Simulador | Core-ES">
              <h3 class="text-uppercase mt-3 branco light h3-box mb-3">Simulador de<br class="hide-992" /> valores</h3>
              <button class="btn-box azul">Simular</button>
            </div>
          </div>
        </a>
      </div>

                                                                
       <div class="col-lg-3 col-sm-6 pb-15">
        <a href="/agendamento" class="d-block h-100">
          <div class="box text-center azul-escuro-bg">
            <div class="inside-box">
              <img src="{{ asset('img/appointment.png') }}" class="inside-img" alt="AGENDAMENTO DE ATENDIMENTO" />
              <h3 class="text-uppercase mt-3 branco light h3-box mb-3">AGENDAMENTO DE ATENDIMENTO</h3>
              <button href="#" class="btn-box azul-escuro">ACESSAR</button>
            </div>
          </div>
        </a>
      </div>                                                               
                                                                
    
      <div class="col-lg-3 col-sm-6 pb-15">
        <a href="/cartilha-do-representante" class="d-block h-100">
          <div class="box text-center azul-bg">
            <div class="inside-box">
              <img src="{{ asset('img/open-book.png') }}" class="inside-img" alt="Cartilha do Representante | Core-ES" />
              <h3 class="text-uppercase mt-3 branco light h3-box mb-3">Cartilha do<br class="hide-992" /> Representante</h3>
              <button class="btn-box azul">Visualizar</button>
            </div>
          </div>
        </a>
      </div>
      {{--<div class="col-lg-3 col-sm-6 pb-15">
        <!-- <a href="/noticias/anuidade-2021-taxas-e-emolumentos" class="d-block h-100"> -->
          <div class="box text-center azul-escuro-bg">
            <div class="inside-box">
              <img src="{{ asset('img/003-bill.png') }}" class="inside-img" alt="Anuidade 2019 | Core-ES" />
              <h3 class="text-uppercase mt-3 branco light h3-box mb-3">Anuidade 2021<br class="hide-992" /> taxas e emolumentos</h3>
              <!-- <button href="#" class="btn-box azul-escuro">ACESSAR</button> -->
            </div>
          </div>
        <!-- </a> -->
      </div>--}}

      <div class="col-lg-3 col-sm-6 pb-15">
        <a href="{{ route('cursos.index.website') }}" class="d-block h-100">
          <div class="box text-center azul-escuro-bg">
            <div class="inside-box">
              <img src="{{ asset('img/icone-curso.png') }}" class="inside-img" alt="Cursos" />
              <h3 class="text-uppercase mt-3 branco light h3-box mb-3">Cursos</h3>
              <button href="#" class="btn-box azul-escuro">ACESSAR</button>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-sm-6 pb-15">
        <a href="{{ route('agenda-institucional') }}" class="d-block h-100">
          <div class="box text-center azul-escuro-bg">
            <div class="inside-box">
              <img src="{{ asset('img/appointment.png') }}" class="inside-img" alt="Serviços do Atendimento" />
              <h3 class="text-uppercase mt-3 branco light h3-box mb-3">Agenda<br class="hide-992" /> Institucional</h3>
              <button href="#" class="btn-box azul-escuro">ACESSAR</button>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-sm-6 pb-15">
        <a href="https://Core-ES.implanta.net.br/portaltransparencia/#publico/inicio" class="d-block h-100">
          <div class="box text-center azul-bg">
            <div class="inside-box">
              <img src="{{ asset('img/icone-portal-da-transparencia.png') }}" class="inside-img" alt="Portal da transparência" />
              <h3 class="text-uppercase mt-3 branco light h3-box mb-3">Portal da <br class="hide-992" /> Transparência</h3>
              <button href="#" class="btn-box azul-escuro">ACESSAR</button>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-sm-6 pb-15">
        <a href="https://Core-ES.implanta.net.br/portaltransparencia/#OUV/Home" class="d-block h-100">
          <div class="box text-center azul-escuro-bg">
            <div class="inside-box">
              <img src="{{ asset('img/icone-denuncie.png') }}" class="inside-img" alt="Exercício ilegal da profissão" />
              <h3 class="text-uppercase mt-3 branco light h3-box mb-3">Denuncie o Exercício<br class="hide-992" /> Ilegal da Profissão</h3>
              <button href="#" class="btn-box azul-escuro">ACESSAR</button>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-sm-6 pb-15">
        <a href="/noticias/Core-ES-e-a-protecao-de-dados-pessoais" class="d-block h-100">
          <div class="box text-center azul-bg">
            <div class="inside-box">
              <img src="{{ asset('img/icone-termo.png') }}" class="inside-img" alt="Termo de Consentimento" />
              <h3 class="text-uppercase mt-3 branco light h3-box mb-3">Termo de Consentimento</h3>
              <button href="#" class="btn-box azul-escuro">ACESSAR</button>
            </div>
          </div>
        </a>
      </div>

    </div>
  </div>
</section>

<section id="beneficios" class="mb-2">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="beneficios-box row nomargin">
          <div class="col-lg-7 beneficios-txt center-992">
            <h2 class="stronger text-white text-uppercase">Programa de Incentivos</h2>
            <p class="text-white light">O Core-ES traz benefícios diferenciados para Representantes Comerciais.</p>
            <p class="text-white light"></p>
            <div>
              <a href="/programa-de-incentivos" class="btn-beneficios">saiba mais</a>
             <!-- <a href="https://chat.whatsapp.com/HPAXB7yne537CRQChfRfQe" class="btn-beneficios bg-white"><i class="fab fa-whatsapp fa-lg"></i> Grupo WhatsApp</a> -->
            </div>
          </div>
          <div class="col-lg-5 hide-992">
            <img class="lazy" data-src="{{ asset('img/arte-capa004.png') }}" id="computer" alt="Programa de Benefícios | Core-ES" />
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="fale">
  <div class="container">
    <div class="row faleRow">
      <div class="col-md-6 pb-30-768">
        <div class="home-title">
          <blockquote>
            <i></i>
            <h2 class="pr-3 ml-1">Cotidiano</h2>
          </blockquote>
        </div>
        @foreach($cotidianos as $resultado)
          @include('site.inc.noticia-min-grid')
        @endforeach
      </div>
      <div class="col-md-6">
        <div class="home-title">
          <blockquote>
            <i></i>
            <h2 class="pr-3 ml-1">Fale com o Core-ES</h2>
          </blockquote>
        </div>
        <div class="row">
          <div class="col-lg-6 faleSingle">
            <div class="row nomargin">
              <div class="align-self-center">
                <img src="{{ asset('img/phone_novo.png') }}" class="inside-img" alt="Atendimento | Core-ES">
              </div>
              <div class="flex-one fale-txt align-self-center">
                <h5 class="normal">Atendimento<br class="hide-992" /> (27) 3223-3502</h5>
              </div>
            </div>
          </div>
          <div class="col-lg-6 faleSingle">
            <a href="https://wa.me/552732233502?text=Olá%20poderia%20me%20ajudar?" target="_blank">
              <div class="row nomargin">
                <div class="align-self-center">
                  <img src="{{ asset('img/whatsapp_novo.png') }}" alt="Whatsapp | Core-ES">
                </div>
                <div class="flex-one fale-txt align-self-center">
                  <h5 class="normal">Iniciar uma conversa</h5>
                </div>
              </div>
            </a>
          </div>
        </div>
        <div class="home-title mt-4">
          <blockquote>
            <i></i>
            <h2 class="pr-3 ml-1">Core-ES nas Mídias Sociais</h2>
          </blockquote>
        </div>
        <div class="row">
          <div class="col-lg-6 faleSingle">
            <a href="https://www.facebook.com/core.es.oficial" target="_blank">
              <div class="row nomargin">
                <div class="align-self-center">
                  <img src="{{ asset('img/facebook_novo.png') }}" class="inside-img" alt="Facebook | Core-ES">
                </div>
                <div class="flex-one fale-txt align-self-center">
                  <h5 class="normal">Siga-nos no<br class="hide-992" /> Facebook</h5>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-6 faleSingle">
            <a href="https://twitter.com/core_es_oficial" target="_blank">
              <div class="row nomargin">
                <div class="align-self-center">
                  <img src="{{ asset('img/twitter_novo.png') }}" class="inside-img" alt="Twitter | Core-ES">
                </div>
                <div class="flex-one fale-txt align-self-center">
                  <h5 class="normal">Siga-nos no<br class="hide-992" /> no Twitter</h5>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-6 faleSingle">
            <a href="https://www.instagram.com/core.es.oficial/" target="_blank">
              <div class="row nomargin">
                <div class="align-self-center">
                  <img src="{{ asset('img/instagram_novo.png') }}" class="inside-img" alt="Instagram | Core-ES">
                </div>
                <div class="flex-one fale-txt align-self-center">
                  <h5 class="normal">Siga-nos no<br class="hide-992" /> Instagram</h5>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-6 faleSingle">
            <a href="https://www.linkedin.com/company/core-es">
              <div class="row nomargin">
                <div class="align-self-center">
                  <img src="{{ asset('img/linkedin_novo.png') }}" class="inside-img" alt="LinkedIn | Core-ES">
                </div>
                <div class="flex-one fale-txt align-self-center">
                  <h5 class="normal">Siga-nos no<br class="hide-992" /> LinkedIn</h5>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="eouv-calendario" class="pb-5">
  <div class="container">
    <div class="row mb-2">
      <div class="col">
        <div class="home-title">
          <blockquote>
            <i></i>
            <h2 class="pr-3 ml-1">Blog</h2>
          </blockquote>
        </div>
        <div></div>
      </div>
    </div>
    <div class="row" id="home-blog">
      @foreach($posts as $post)
        @include('site.inc.post-grid')
      @endforeach
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="home-title">
          <blockquote>
            <i></i>
            <h2 class="pr-3 ml-1">E-ouv</h2>
          </blockquote>
        </div>
        <div class="row">
          <div class="col-sm-8">
            <a href="http://Core-ES.implanta.net.br/portaltransparencia/#OUV/Home" target="_blank">
              <img class="lazy" data-src="{{ asset('img/computer.png') }}" alt="E-OUV | Core-ES" />
            </a>
          </div>
          <div class="col-sm-4 hide-576 eouv-imgs align-self-center pl-3 center-992">
            <div class="m-auto pb-3">
              <a href="http://Core-ES.implanta.net.br/portaltransparencia/#OUV/Home" target="_blank">
                <img src="{{ asset('img/ie-1.png') }}" class="azul-bg" data-toggle="tooltip" title="Fale Conosco" alt="Fale Conosco | Core-ES" />
              </a>
              <a href="http://Core-ES.implanta.net.br/portaltransparencia/#OUV/Home" target="_blank">
                <img src="{{ asset('img/ie-2.png') }}" class="azul-escuro-bg" data-toogle="tooltip" title="Ouvidoria" alt="Ouvidoria | Core-ES" />
              </a>
            </div>
            <div class="m-auto pb-3">
              <a href="http://Core-ES.implanta.net.br/portaltransparencia/#OUV/Home" target="_blank">
                <img src="{{ asset('img/ie-3.png') }}" class="verde-escuro-bg" data-toogle="tooltip" title="Elogios" alt="Elogios | Core-ES" />
              </a>
              <a href="http://Core-ES.implanta.net.br/portaltransparencia/#OUV/Home" target="_blank">
                <img src="{{ asset('img/ie-4.png') }}" class="azul-bg" data-toogle="tooltip" title="Sugestões" alt="Sugestões | Core-ES" />
              </a>
            </div>
            <div class="m-auto">
              <a href="http://Core-ES.implanta.net.br/portaltransparencia/#OUV/Home" target="_blank">
                <img src="{{ asset('img/ie-5.png') }}" class="azul-escuro-bg" data-toogle="tooltip" title="Reclamações" alt="Reclamações | Core-ES" />
              </a>
              <a href="http://Core-ES.implanta.net.br/portaltransparencia/#OUV/Home" target="_blank">
                <img src="{{ asset('img/ie-6.png') }}" class="verde-escuro-bg" data-toogle="tooltip" title="Dúvidas" alt="Dúvidas | Core-ES" />
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 mt-2-992">
        <div class="home-title">
          <blockquote>
            <i></i>
            <h2 class="pr-3 ml-1">Calendário</h2>
          </blockquote>
        </div>
        <div id="calendario" class="row">
          <div class="col-sm-8">
            <a href="/calendario-oficial-Core-ES">
              <img class="lazy" data-src="{{ asset('img/arte-calendario-2023.png') }}" alt="Calendário | Core-ES" />
            </a>
          </div>
          <div class="col-sm-4 hide-576 align-self-center text-right pr-4">
            <div class="calendario-txt">
              <p class="preto">Confira o calendário completo de<br>atendimento e expediente <br>de sua região.</p>
              <a href="/calendario-oficial-Core-ES" class="btn-calendario mt-4">
                <h4 class="normal">confira</h4>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
