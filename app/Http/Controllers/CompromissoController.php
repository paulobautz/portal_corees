<?php

namespace App\Http\Controllers;

use App\Events\CrudEvent;
use App\Traits\TabelaAdmin;
use Illuminate\Http\Request;
use App\Traits\ControleAcesso;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CompromissoRequest;
use App\Repositories\CompromissoRepository;

class CompromissoController extends Controller
{
    use ControleAcesso, TabelaAdmin;

    private $compromissoRepository;

    public function __construct(CompromissoRepository $compromissoRepository)
    {
        $this->middleware('auth');
        $this->compromissoRepository = $compromissoRepository;
        $this->variaveis = [
            'singular' => 'compromisso',
            'singulariza' => 'o compromisso',
            'plural' => 'compromissos',
            'pluraliza' => 'compromisso',
            'titulo_criar' => 'Registrar compromisso'
        ];
    }

    public function index(Request $request)
    {
        //$this->autoriza($this->class, "index");

        $variaveis = $this->variaveis;

        // Checa se tem filtro
        if($request->filtro === 'sim') {

            $regras = [
                'data' => 'date_format:d/m/Y'
            ];
    
            // Valida os campos de acordo com as regras
            $validacao = Validator::make($request->all(), $regras, []);
            
            // Caso algum erro ocorra, retorna para a tela do fomulário com mensagens de erro
            if($validacao->fails()) {
                return redirect()->back()->with('message', '<i class="icon fa fa-ban"></i>Data do filtro inválida')
                        ->with('class', 'alert-danger');
            }

            $temFiltro = true;

            $variaveis['continuacao_titulo'] = '<i>(filtro ativo)</i>';

            $resultados = $this->compromissoRepository->getByData(date('Y-m-d', strtotime(str_replace('/', '-', $request->data))));
        } 
        else {
            $temFiltro = null;
            $diaFormatado = date('d\/m\/Y');
            $variaveis['continuacao_titulo'] = 'para <strong>' . $diaFormatado . '</strong>';

            $resultados = $this->compromissoRepository->getByData(date('Y-m-d'));
        }

        $tabela = $this->tabelaCompleta($resultados);
        $variaveis['filtro'] = $this->montaFiltros($request);
        $variaveis['mostraFiltros'] = true;
        $variaveis = (Object)  $variaveis;

        return view('admin.crud.home', compact('tabela', 'variaveis', 'resultados', 'temFiltro'));
    }

    public function create()
    {
        //$this->autoriza($this->class, __FUNCTION__);

        $variaveis = (object) $this->variaveis;

        return view('admin.crud.criar', compact('variaveis'));
    }

    public function store(CompromissoRequest $request)
    {
        //$this->autoriza($this->class, __FUNCTION__);

        $compromisso = $this->compromissoRepository->store($request);

        if(!$compromisso) {
            abort(500, 'Erro ao salvar o compromisso');
        }

        event(new CrudEvent('compromisso', 'criou', $compromisso->id));

        return redirect(route('compromisso.index'))
            ->with('message', '<i class="icon fa fa-check"></i>Compromisso criado com sucesso!')
            ->with('class', 'alert-success');

    }

    public function edit($id)
    {
        //$this->autoriza($this->class, __FUNCTION__);

        $resultado = $this->compromissoRepository->getById($id);
        $variaveis = (object) $this->variaveis;

        return view('admin.crud.editar', compact('resultado', 'variaveis'));
    }

    public function update(CompromissoRequest $request, $id)
    {
        //$this->autoriza($this->class, __FUNCTION__);

        $compromisso = $this->compromissoRepository->update($id, $request);

        if(!$compromisso) {
            abort(500, 'Erro ao editar o compromisso');
        }

        event(new CrudEvent('compromisso', 'editou', $id));

        return redirect(route('compromisso.index'))
            ->with('message', '<i class="icon fa fa-check"></i>Compromisso editado com sucesso!')
            ->with('class', 'alert-success');
    }

    public function destroy($id)
    {
        //$this->autoriza($this->class, __FUNCTION__);
        
        $delete = $this->compromissoRepository->deleteBy($id);

        if(!$delete) {
            abort(500, 'Erro ao apagar o compromisso');
        }
            
        event(new CrudEvent('compromisso', 'apagou', $id));

        return redirect(route('compromisso.index'))
            ->with('message', '<i class="icon fa fa-ban"></i>Compromisso apagado com sucesso!')
            ->with('class', 'alert-danger');
    }

    public function busca(Request $request)
    {
        //$this->autoriza($this->class, 'index');

        $busca = $request->q;
        $variaveis = (object) $this->variaveis;
        $resultados = $this->compromissoRepository->getBusca($busca);
        $tabela = $this->tabelaCompleta($resultados);

        return view('admin.crud.home', compact('resultados', 'variaveis', 'tabela', 'busca'));
    }


    public function montaFiltros($request)
    {
        $filtro = '<form method="GET" action="' . route('compromisso.filtro') . '" id="filtroCompromisso" class="mb-0">';
        $filtro .= '<div class="form-row filtroAge">';
        $filtro .= '<input type="hidden" name="filtro" value="sim" />';

        $filtro .= '<div class="form-group mb-0 col">';

        $hoje = date('d\/m\/Y');

        $filtro .= '<label>Data</label>';
       
        if(isset($request->data)) {
            $data = $request->data;
            $filtro .= '<input type="text" class="form-control d-inline-block dataInput form-control-sm" name="data" id="dataFiltro" placeholder="dd/mm/aaaa" value="' . $data . '" />';
        } 
        else {
            $filtro .= '<input type="text" class="form-control d-inline-block dataInput form-control-sm" name="data" id="dataFiltro" placeholder="dd/mm/aaaa" value="' . $hoje . '" />';
        }
        $filtro .= '</div>';

        $filtro .= '<div class="form-group mb-0 col-auto align-self-end">';
        $filtro .= '<input type="submit" class="btn btn-sm btn-default" value="Filtrar" />';
        $filtro .= '</div>';
        $filtro .= '</div>';
        $filtro .= '</form>';

        return $filtro;
    }

    protected function tabelaCompleta($resultados)
    {
        // Opções de cabeçalho da tabela
        $headers = [
            'ID',
            'Data',
            'Início',
            'Término',
            'Local', 
            'Título',
            'Ações'
        ];
        // Opções de conteúdo da tabela
        $contents = [];

        foreach($resultados as $resultado) {
            $acoes = '<a href="/admin/compromissos/edit/'.$resultado->id.'" class="btn btn-sm btn-default">Editar</a> ';
            
            $acoes .= '<form method="POST" action="' . route('compromisso.destroy', $resultado->id) . '" class="d-inline">';
            $acoes .= '<input type="hidden" name="_token" value="'.csrf_token().'" />';
            $acoes .= '<input type="hidden" name="_method" value="delete" />';
            $acoes .= '<input type="submit" class="btn btn-sm btn-danger" value="Apagar" onclick="return confirm(\'Tem certeza que deseja excluir o compromisso?\')" />';
            $acoes .= '</form>';
            
            
            $conteudo = [
                $resultado->id,
                onlyDate($resultado->data),
                onlyHour($resultado->horarioinicio),
                onlyHour($resultado->horariotermino),
                $resultado->local,
                $resultado->titulo,
                $acoes
            ];
            array_push($contents, $conteudo);
        }

        // Classes da tabela
        $classes = [
            'table',
            'table-bordered',
            'table-striped'
        ];
        $tabela = $this->montaTabela($headers, $contents, $classes);
        
        return $tabela;
    }
}
