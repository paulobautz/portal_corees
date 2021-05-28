@extends('site.representante.app')

@section('content-representante')

<div class="representante-content w-100">
    <div class="nomargin conteudo-txt-mini light">
        <h4 class="pt-1 pb-1">Simulador Refis para anuidades em aberto</h4>
        <div class="linha-lg-mini mb-3"></div>
        @if ($total !== 0)
        <p>Selecione as anuidades em aberto para consultar valores com descontos. Atenção, parcela deve ter o valor mínimo de R$ 100,00 (cem reais).</p>

        <h5 class="mt-0 mb-2"><i class="fas fa-level-up-alt rotate-90"></i>&nbsp;&nbsp;Valores</h5>
        <table class="table table-bordered bg-white mb-0">
            <tbody>
                <tr>
                    <td class="ls-meio-neg">Total s/ desconto</td>
                    <td class="ls-meio-neg"><div id="total" value="{{ $total }}">R$ {{ toReais($total) }}</div></td>
                </tr>
                <tr>
                    @if($nParcelas90[0] !== 0)
                        <td class="ls-meio-neg">Total c/ 90% de desconto<p class="text-left"><small>* pagamento à vista, no boleto ou em até {{ end($nParcelas90) }} parcelas no cartão de crédito</small></p></td>
                        <td class="ls-meio-neg"><div id="total90" value="{{ $total90 }}">R$ {{ toReais($total90) }}</div></td>
                        <td class="ls-meio-neg">
                            <select id="nParcela90" class="form-control">
                                <option value="0" selected>Número de parcelas</option>
                                @foreach($nParcelas90 as $n)
                                    <option value="{{ $n }}">{{ $n }}</option>
                                @endforeach
                        </td>
                        <td id="parcelamento90" class="ls-meio-neg">-</td>
                    @else
                        <td class="ls-meio-neg">Total c/ 90% de desconto<p class="text-left"><small>* não disponível</small></p></td>
                        <td class="ls-meio-neg"><div id="total90" value="0">-</div></td>
                        <td class="ls-meio-neg">-</td>
                        <td class="ls-meio-neg">-</td>
                    @endif
                </tr>
                <tr>
                    <td class="ls-meio-neg">Total c/ 80% de desconto<p class="text-left"><small>* pagamento de 2 a 6 parcelas no boleto</small></p></td>
                    <td class="ls-meio-neg"><div id="total80" value="{{ $total80 }}">R$ {{ toReais($total80) }}</div></td>
                </tr>
                <tr>
                    <td class="ls-meio-neg">Total c/ 60% de desconto<p class="text-left"><small>* para pagamento de 7 a 12 parcelas no boleto</small></p></td>
                    <td class="ls-meio-neg"><div id="total60" value="{{ $total60 }}">R$ {{ toReais($total60) }}</div></td>
                </tr>
            </tbody>
        </table>

        @else
        <p>Não foi encontrada nenhuma anuidade em aberto elegível para Refis. Não é possível consultar valores com descontos.</p>
        @endif

    </div>            
</div>

@endsection