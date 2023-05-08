@extends('site.layout.app', ['title' => 'Agendamento'])

@section('content')

<section id="pagina-cabecalho">
  <div class="container-fluid text-center nopadding position-relative">
    <img src="{{ asset('img/banner-interno-agendamento002.2.jpg') }}" />
    <div class="row position-absolute pagina-titulo">
      <div class="container text-center">
        <h1 class="branco text-uppercase">
          Agendamento<br>Representante Comercial
        </h1>
      </div>
    </div>
  </div>
</section>

<section id="pagina-licitacao">
  <div class="container">
    <div class="row" id="conteudo-principal">
      <div class="col">
        <div class="row nomargin">
          <div class="flex-one pr-3 align-self-center">
            <h2 class="stronger">Representante Comercial, marque seu atendimento no Core-ES</h2>
          </div>
          <div class="align-self-center">
            <a href="/" class="btn-voltar">Voltar</a>
          </div>
        </div>
      </div>
    </div>
    <div class="linha-lg"></div>
    <div class="row mb-4">
      <div class="col">
        <div class="conteudo-txt">
          
          <p><strong>Importante:</strong> Em caso de solicitação de cancelamento com tratativas de Ação de Execução Fiscal, o atendimento será realizado somente pelo Atendimento Jurídico.</p>
          
          <p class="pb-0 text-justify">
            <strong>Representante Comercial</strong>, agende seu atendimento presencial com até 60 dias de antecedência.
            </br></br>
            <strong>Atenção:</strong> Orientação jurídica – dúvidas deverão ser enviadas para o e-mail juridico@core-es.org.br.
            </br></br>
          </p>
        </div>
        <div class="mt-2">
        @if(session('message'))
          <div class="d-block w-100">
            <p class="alert {{ session('class') }}">{!! session('message') !!}</p>
          </div>
        @endif
          <iframe src='https://outlook.office365.com/owa/calendar/AgendaCoreES@core-es.org.br/bookings/' width='100%' height='2100' scrolling='yes' style='border:0'></iframe>
        </div>
      </div>
    </div>
  </div>
  <!-- The Modal -->
  <div class="modal fade" id="avisoCarteirinha">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Atenção, Representante Comercial!</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body" id="textoCarteirinha">
        </div>
      </div>
    </div>
  </div>

  <!-- The Modal -->
  <div class="modal fade" id="tipo-outros">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Atenção</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body" id="textoOutros">
          Você é Representante Comercial?
        </div>
         <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-dismiss="modal">Sim</button>
          <button type="button" class="btn btn-secondary" id="notRC-agendamento">Não</button>
        </div>
      </div>
    </div>
  </div>

  <div id="dialog_agendamento" title="Atenção"></div>
</section>

@endsection
