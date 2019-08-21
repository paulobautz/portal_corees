@extends('site.layout.app', ['title' => 'Simulador'])

@section('content')

@php
    use Illuminate\Support\Facades\Input;
    use \App\Http\Controllers\Helper;
@endphp

<section id="pagina-cabecalho" class="mt-1">
  <div class="container-fluid text-center nopadding position-relative pagina-titulo-img">
    <img src="{{ asset('img/banner-simulador.jpg') }}" />
    <div class="row position-absolute pagina-titulo">
      <div class="container text-center">
        <h1 class="branco text-uppercase">
          Simulador de Cálculos
        </h1>
      </div>
    </div>
  </div>
</section>

<section id="pagina-busca">
  <div class="container">
    <div class="row" id="conteudo-principal">
      <div class="col">
        <div class="row nomargin">
          <div class="flex-one pr-4 align-self-center">
            <h4 class="stronger">Representante já pode consultar, com mais facilidade, sua situação junto ao Conselho!</h4>
          </div>
          <div class="align-self-center">
            <a href="/" class="btn-voltar">Voltar</a>
          </div>
        </div>
      </div>
    </div>
    <div class="linha-lg"></div>
    <div class="row mt-2" id="conteudo-principal">
      <div class="col-lg-8">
        <div class="row nomargin">
          <p class="mb-2">O simulador de cálculos, novo serviço oferecido pelo Core-SP, é uma solução informatizada que permite a consulta sobre regularização dos registros e identificação de possíveis pendências financeiras junto ao Conselho.</p>
          <p class="mb-2">Um recurso simples, ágil e moderno que visa contribuir para uma melhor administração do tempo de representantes comerciais e de seus contadores.</p>
          <p class="mb-2">Importante ressaltar que as informações recebidas no simulador de cálculos são para simples conferência, devendo o profissional comparecer na sede ou seccionais, para eventual regularização, naquela data.</p>
        </div>
        <div class="row nomargin mt-3">
          <form method="post" class="w-100 simulador">
            @csrf
            <div class="form-row">
              <div class="col">
                <label for="tipoPessoa">Tipo de Pessoa</label>
                <select name="tipoPessoa" id="tipoPessoa" class="form-control">
                  @foreach(Helper::tipoPessoa() as $key => $tipo)
                    <option value="{{ $key }}" {{ Input::get('tipoPessoa') == $key ? 'selected' : '' }}>{{ $tipo }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col">
                <label for="dataInicio">Data de início das atividades</label>
                <input
                  type="text"
                  name="dataInicio"
                  id="dataInicio" 
                  class="form-control dataInput {{ $errors->has('dataInicio') ? 'is-invalid' : '' }}"
                  value="{{ Input::get('dataInicio') }}"
                  placeholder="dd/mm/aaaa"
                  autocomplete="off"
                  readonly
                />
                @if($errors->has('dataInicio'))
                  <div class="invalid-feedback">
                    {{ $errors->first('dataInicio') }}
                  </div>
                @endif
              </div>
            </div>
            <div class="form-row mt-2" id="simuladorAddons" style="{{ Input::get('tipoPessoa') == 1 ? 'display: flex;' : '' }}">
              <div class="col-6">
                <label for="capitalSocial">Capital Social</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text">R$</span>
                  </div>
                  <input
                    type="text"
                    id="capitalSocial"
                    name="capitalSocial"
                    class="form-control capitalSocial"
                    placeholder="1,00"
                    value="{{ Input::get('capitalSocial') }}"
                    maxlength="15"
                  />
                </div>
              </div>
              <div class="col-6">
                <div class="form-check">
                  <input
                    type="checkbox"
                    name="filialCheck"
                    id="filialCheck"
                    class="form-check-input"
                    {{ Input::get('filialCheck') == 'on' ? 'checked' : '' }}
                  />
                  <label for="form-check-label" for="filialCheck">Filial</label>
                </div>
                <select name="filial" id="filial" class="form-control" {{ Input::get('filialCheck') == 'on' ? '' : 'disabled' }}>
                  <option value="50" {{ Input::get('filial') == 50 ? 'selected' : '' }}></option>
                  @foreach(Helper::listaCores() as $key => $filial)
                    <option value="{{ $key }}" {{ Input::get('filial') == $key ? 'selected' : '' }}>{{ $filial }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-6 mt-2">
                <div class="form-check">
                  <input
                    type="checkbox"
                    name="empresaIndividual"
                    id="empresaIndividual"
                    class="form-check-input"
                    {{ Input::get('empresaIndividual') == 'on' ? 'checked' : '' }}
                  />
                  <label for="form-check-label" for="empresaIndividual">Empresa Individual</label>
                </div>
              </div>
            </div>
            <div class="form-row mt-2">
              <div class="col">
                <input type="submit" value="Simular {{ Input::has('dataInicio') ? ' novamente' : '' }}" class="btn btn-primary">
              </div>
            </div>
          </form>
        </div>
        @if(isset($total) || isset($extrato) || isset($taxas))
        <div class="row nomargin mt-4">
          <h4 class="mb-1">Pessoa {{ Helper::tipoPessoa()[Input::get('tipoPessoa')] }} {{ Input::get('filial') && Input::get('filial') !== '50' ? ' (' . Helper::listaCores()[Input::get('filial')] . ')' : '' }}</h4>
          <table class="table table-sm table-hover">
            <thead>
              <tr>
                <th class="border-3">Descrição</th>
                <th class="border-3">Valor</th>
              </tr>
            </thead>
            <tbody>
              @foreach($extrato as $cobranca)
                <tr>
                  <td>{{ $cobranca['DESCRICAO'] }}</td>
                  <td>{{ 'R$ ' . str_replace('.', ',', $cobranca['VALOR_TOTAL']) }}</td>
                </tr>
              @endforeach
              <tr class="blank-row"><td colspan="2"></td></tr>
              @foreach($taxas as $cobranca)
                <tr>
                  <td>{{ utf8_encode($cobranca['TAX_DESCRICAO']) }}</td>
                  <td>{{ 'R$ ' . str_replace('.', ',', $cobranca['TAX_VALOR']) }}</td>
                </tr>
              @endforeach
              <tr class="blank-row"><td colspan="2"></td></tr>
              <tr>
                <td class="text-right pt-2"><strong>Total:</strong></td>
                <td class="pt-2">R$ {{ $total }}</td>
              </tr>
            </tbody>
          </table>
          @if(isset($rt))
            <h4 class="mb-1">Pessoa Física RT</h4>
            <table class="table table-sm table-hover">
              <thead>
                <th class="border-3">Descrição</th>
                <th class="border-3">Valor</th>
              </thead>
              <tbody>
                @foreach($rt as $cobranca)
                  <tr>
                    <td>{{ $cobranca['DESCRICAO'] }}</td>
                    <td>{{ 'R$ ' . str_replace('.', ',', $cobranca['VALOR_TOTAL']) }}</td>
                  </tr>
                @endforeach
                <tr class="blank-row"><td colspan="2"></td></tr>
                @foreach($rtTaxas as $cobranca)
                  <tr>
                    <td>{{ utf8_encode($cobranca['TAX_DESCRICAO']) }}</td>
                    <td>{{ 'R$ ' . str_replace('.', ',', $cobranca['TAX_VALOR']) }}</td>
                  </tr>
                @endforeach
                <tr class="blank-row"><td colspan="2"></td></tr>
                <tr>
                  <td class="text-right pt-2"><strong>Total:</strong></td>
                  <td class="pt-2">R$ {{ str_replace('.', ',', $rtTotal) }}</td>
                </tr>
              </tbody>
            </table>
            <h4 class="mt-2"><span class="light">Total geral:</span> R$ {{ $totalGeral  }}</h4>
          @endif
        </div>
        @endif
      </div>
      <div class="col-lg-4">
        @include('site.inc.content-sidebar')
      </div>
    </div>
  </div>
</section>

@endsection