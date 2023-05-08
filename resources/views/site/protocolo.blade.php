@extends('site.layout.app', ['title' => 'Protocolo Online'])

@section('description')
  <meta name="description" content="Sistema para acompanhamento dos status das solicitações." />
@endsection

@section('content')

@php
use \App\ProtocoloOnline;
@endphp

<section id="pagina-cabecalho">
  <div class="container-fluid text-center nopadding position-relative pagina-titulo-img">
    <img src="{{ asset('img/bdo.png') }}" />
    <div class="row position-absolute pagina-titulo" id="bdo-titulo">
      <div class="container text-center">
        <h1 class="branco text-uppercase">
          Protocolo Online
        </h1>
      </div>
</section>

<section id="pagina-bdo">
  <div class="container">
    <div class="row pb-4" id="conteudo-principal">
      <div class="col">
        <form method="GET" role="form" action="/protocolo/busca" class="pesquisaLicitacao">
          <div class="form-row text-center">
            <div class="m-auto">
              <h5 class="text-uppercase stronger marrom">Buscar Protocolo</h5>
            </div>
          </div>
          <div class="linha-lg-mini"></div>
          <div class="form-row">
            <div class="col">
             <br>
              <input type="number" min="1" required="required"
                name="numero"
                class="form-control {{ !empty(Request::input('numero')) ? 'bg-focus border-info' : '' }}"
                placeholder="Nº do Protocolo"
                id="numero"
                @if(!empty(Request::input('numero')))
                value="{{ Request::input('numero') }}"
                @endif
                />
            </div>
            <div class="col">
                </br>
            <button type="submit" class="btn-buscaavancada"><i class="fas fa-search"></i>&nbsp;&nbsp;Pesquisar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="linha-cinza"></div>
    </div>
  </div>
  <div class="container">
    <div class="row mt-4">
      <div class="col">
       @if(isset($protocolos))
          @foreach($protocolos as $protocolo)
          <div class="licitacao-grid">
            <div class="licitacao-grid-main">
              <p>{!! html_entity_decode($protocolo->content) !!}</p>
              <div class="bdo-info">
              </div>
            </div>
            <div class="licitacao-grid-bottom">
              <div class="col nopadding">
                <div class="text-right">
                  <h6 class="light marrom"><strong>Data e Hora:</strong> {{ date('d/m/Y H:m:s',strtotime($protocolo->date)) }}</h6>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        @else
        <p>Nenhuma protocolo encontrado!</p>
        @endif
      </div>
    </div>
    @if(isset($protocolos))
    <div class="row">
      <div class="col">
        <div class="float-right">
          {{ $protocolos->appends(request()->input())->links() }}
        </div>
      </div>
    </div>
    @endif
  </div>    
</section>

@endsection