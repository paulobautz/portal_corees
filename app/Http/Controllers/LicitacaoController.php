<?php

namespace App\Http\Controllers;

// use App\Licitacao;
// use App\Events\CrudEvent;
// use App\Traits\TabelaAdmin;
use Illuminate\Http\Request;
use App\Http\Requests\LicitacaoRequest;
// use App\Repositories\LicitacaoRepository;
// use Illuminate\Support\Facades\Request as IlluminateRequest;
use App\Contracts\MediadorServiceInterface;

class LicitacaoController extends Controller
{
    // use TabelaAdmin;

    // private $class = 'LicitacaoController';
    // private $licitacaoRepository;
    // private $variaveis;
    private $service;

    public function __construct(/*LicitacaoRepository $licitacaoRepository, */MediadorServiceInterface $service)
    {
        $this->middleware('auth', ['except' => ['show', 'siteGrid', 'siteBusca']]);
        // $this->licitacaoRepository = $licitacaoRepository;
        // $this->variaveis = [
        //     'singular' => 'licitacao',
        //     'singulariza' => 'a licitação',
        //     'plural' => 'licitacoes',
        //     'pluraliza' => 'licitações',
        //     'titulo_criar' => 'Cadastrar licitação',
        //     'btn_criar' => '<a href="'.route('licitacoes.create').'" class="btn btn-primary mr-1">Nova Licitação</a>',
        //     'btn_lixeira' => '<a href="'.route('licitacoes.trashed').'" class="btn btn-warning">Licitações Deletadas</a>',
        //     'btn_lista' => '<a href="'.route('licitacoes.index').'" class="btn btn-primary mr-1">Lista de Licitações</a>',
        //     'titulo' => 'Licitações Deletadas'
        // ];
        $this->service = $service;
    }

    public function index()
    {
        $this->authorize('viewAny', auth()->user());

        // $resultados = $this->licitacaoRepository->getToTable();
        // $tabela = $this->tabelaCompleta($resultados);

        // if(auth()->user()->cannot('create', auth()->user())) {
        //     unset($this->variaveis['btn_criar']);
        // }
            
        // $variaveis = (object) $this->variaveis;

        try{
            $dados = $this->service->getService('Licitacao')->listar();
            $variaveis = $dados['variaveis'];
            $tabela = $dados['tabela'];
            $resultados = $dados['resultados'];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            abort(500, "Erro ao carregar as licitações.");
        }

        return view('admin.crud.home', compact('tabela', 'variaveis', 'resultados'));
    }

    public function create()
    {
        $this->authorize('create', auth()->user());

        // $variaveis = (object) $this->variaveis;
        // $modalidades = Licitacao::modalidadesLicitacao();
        // $situacoes = Licitacao::situacoesLicitacao();

        try{
            $dados = $this->service->getService('Licitacao')->view();
            $variaveis = $dados['variaveis'];
            $modalidades = $dados['modalidades'];
            $situacoes = $dados['situacoes'];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            abort(500, "Erro ao carregar a página para criar a licitação.");
        }

        return view('admin.crud.criar', compact('variaveis', 'modalidades', 'situacoes'));
    }

    public function store(LicitacaoRequest $request)
    {
        $this->authorize('create', auth()->user());

        // $request->validated();
        
        // $save = $this->licitacaoRepository->store($request);

        // if(!$save) {
        //     abort(500);
        // }

        // event(new CrudEvent('licitação', 'criou', $save->idlicitacao));

        try{
            $validated = $request->validated();
            $user = auth()->user();
            $this->service->getService('Licitacao')->save($validated, $user);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            abort(500, "Erro ao criar a licitação.");
        }

        return redirect()->route('licitacoes.index')
            ->with('message', '<i class="icon fa fa-check"></i>Licitação cadastrada com sucesso!')
            ->with('class', 'alert-success');
    }

    public function edit($id)
    {
        $this->authorize('updateOther', auth()->user());

        // $resultado = $this->licitacaoRepository->findById($id);
        // $variaveis = (object) $this->variaveis;
        // $modalidades = Licitacao::modalidadesLicitacao();
        // $situacoes = Licitacao::situacoesLicitacao();

        try{
            $dados = $this->service->getService('Licitacao')->view($id);
            $variaveis = $dados['variaveis'];
            $resultado = $dados['resultado'];
            $modalidades = $dados['modalidades'];
            $situacoes = $dados['situacoes'];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            abort(500, "Erro ao carregar a página para editar a licitação.");
        }

        return view('admin.crud.editar', compact('resultado', 'variaveis', 'modalidades', 'situacoes'));
    }

    public function update(LicitacaoRequest $request, $id)
    {
        $this->authorize('updateOther', auth()->user());

        // $request->validated();
        
        // $update = $this->licitacaoRepository->update($id, $request);

        // if(!$update) {
        //     abort(500);
        // }
            
        // event(new CrudEvent('licitação', 'editou', $id));

        try{
            $validated = $request->validated();
            $user = auth()->user();
            $this->service->getService('Licitacao')->save($validated, $user, $id);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            abort(500, "Erro ao editar a licitação.");
        }

        return redirect()->route('licitacoes.index')
            ->with('message', '<i class="icon fa fa-check"></i>Licitação com a ID: ' . $id . ' foi editada com sucesso!')
            ->with('class', 'alert-success');
    }

    public function show($id)
    {
        // $licitacao = $this->licitacaoRepository->findById($id);

        try{
            $licitacao = $this->service->getService('Licitacao')->viewSite($id);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            abort(500, "Erro ao carregar a página da licitação no portal.");
        }

        return response()
            ->view('site.licitacao', compact('licitacao'))
            ->header('Cache-Control','no-cache');
    }

    public function destroy($id)
    {
        $this->authorize('delete', auth()->user());
        
        // $delete = $this->licitacaoRepository->findById($id)->delete();

        // if(!$delete) {
        //     abort(500);
        // }
            
        // event(new CrudEvent('licitação', 'apagou', $id));

        try{
            $this->service->getService('Licitacao')->destroy($id);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            abort(500, "Erro ao excluir a licitação.");
        }

        return redirect()->route('licitacoes.index')
            ->with('message', '<i class="icon fa fa-check"></i>Licitação com a ID: ' . $id . ' foi deletada com sucesso!')
            ->with('class', 'alert-success');
    }

    public function lixeira()
    {
        $this->authorize('onlyAdmin', auth()->user());

        // $variaveis = (object) $this->variaveis;
        // $resultados = $this->licitacaoRepository->getTrashed();
        // $tabela = $this->tabelaTrashed($resultados);

        try{
            $dados = $this->service->getService('Licitacao')->lixeira();
            $variaveis = $dados['variaveis'];
            $tabela = $dados['tabela'];
            $resultados = $dados['resultados'];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            abort(500, "Erro ao carregar as licitações excluídas.");
        }

        return view('admin.crud.lixeira', compact('tabela', 'variaveis', 'resultados'));
    }

    public function restore($id)
    {
        $this->authorize('onlyAdmin', auth()->user());
        
        // $restore = $this->licitacaoRepository->getTrashedById($id)->restore();

        // if(!$restore) {
        //     abort(500);
        // }
           
        // event(new CrudEvent('licitação', 'restaurou', $id));

        try{
            $this->service->getService('Licitacao')->restore($id);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            abort(500, "Erro ao restaurar a licitação.");
        }

        return redirect()->route('licitacoes.index')
            ->with('message', '<i class="icon fa fa-check"></i>Licitação com a ID: ' . $id . ' foi restaurada com sucesso!')
            ->with('class', 'alert-success');
    }

    public function busca(Request $request)
    {
        $this->authorize('viewAny', auth()->user());

        // $busca = IlluminateRequest::input('q');
        // $variaveis = (object) $this->variaveis;
        // $resultados = $this->licitacaoRepository->getBusca($busca);
        // $tabela = $this->tabelaCompleta($resultados);

        try{
            $busca = $request->q;
            $dados = $this->service->getService('Licitacao')->buscar($busca);
            $resultados = $dados['resultados'];
            $tabela = $dados['tabela'];
            $variaveis = $dados['variaveis'];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            abort(500, "Erro ao buscar o texto em licitações.");
        }

        return view('admin.crud.home', compact('resultados', 'busca', 'tabela', 'variaveis'));
    }

    public function siteGrid()
    {
        // $licitacoes = $this->licitacaoRepository->getSiteGrid();
        // $modalidades = Licitacao::modalidadesLicitacao();
        // $situacoes = Licitacao::situacoesLicitacao();

        try{
            $dados = $this->service->getService('Licitacao')->siteGrid();
            $licitacoes = $dados['licitacoes'];
            $modalidades = $dados['modalidades'];
            $situacoes = $dados['situacoes'];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            abort(500, "Erro ao carregar as licitações no portal.");
        }

        return response()
            ->view('site.licitacoes', compact('licitacoes', 'modalidades', 'situacoes'))
            ->header('Cache-Control','no-cache');
    }

    public function siteBusca(LicitacaoRequest $request)
    {
        // $buscaDia = $request->datarealizacao;

        // $modalidades = Licitacao::modalidadesLicitacao();
        // $situacoes = Licitacao::situacoesLicitacao();

        // // Se nenhum critério foi fornecido, chama método que abre a tela inical de busca
        // if(empty($request->palavrachave) && empty($request->modalidade) && empty($request->situacao) && empty($request->nrlicitacao) && empty($request->nrprocesso) && empty($request->datarealizacao)) {
        //     $this->siteGrid();
        // }

        // if(isset($buscaDia)) {
        //     $diaArray = explode('/', $buscaDia);
        //     $checaDia = (count($diaArray) != 3 || $diaArray[2] == null)  ? false : checkdate($diaArray[1], $diaArray[0], $diaArray[2]);

        //     if($checaDia == false) {
        //         $licitacoes = null;

        //         return view('site.licitacoes', compact('licitacoes', 'modalidades', 'situacoes'))
        //             ->with('erro', 'Data fornecida é inválida');
        //     }

        //     $buscaDia = date('Y-m-d', strtotime(str_replace('/', '-', $buscaDia)));
        // }

        // $licitacoes = $this->licitacaoRepository->getBuscaSite($request->palavrachave, $request->modalidade, $request->situacao, $request->nrlicitacao, $request->nrprocesso, $buscaDia);

        // $busca = true;

        // if (count($licitacoes) == 0) {
        //     $licitacoes = null;
        // } 

        try{
            $validated = $request->validated();
            $dados = $this->service->getService('Licitacao')->siteGrid($validated);
            $licitacoes = $dados['licitacoes'];
            $modalidades = $dados['modalidades'];
            $situacoes = $dados['situacoes'];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            abort(500, "Erro ao buscar as licitações no portal.");
        }

        return view('site.licitacoes', compact('licitacoes', 'modalidades', 'situacoes'));
    }

    // protected function tabelaHeaders()
    // {
    //     return [
    //         'Código',
    //         'Modalidade',
    //         'Nº da Licitação',
    //         'Nº do Processo',
    //         'Situação',
    //         'Data de Realização',
    //         'Ações'
    //     ];
    // }

    // protected function tabelaContents($query)
    // {
    //     return $query->map(function($row){
    //         $acoes = '<a href="/licitacao/'.$row->idlicitacao.'" class="btn btn-sm btn-default" target="_blank">Ver</a> ';
    //         if(auth()->user()->can('updateOther', auth()->user()))
    //             $acoes .= '<a href="'.route('licitacoes.edit', $row->idlicitacao).'" class="btn btn-sm btn-primary">Editar</a> ';
    //         if(auth()->user()->can('delete', auth()->user())) {
    //             $acoes .= '<form method="POST" action="'.route('licitacoes.destroy', $row->idlicitacao).'" class="d-inline">';
    //             $acoes .= '<input type="hidden" name="_token" value="'.csrf_token().'" />';
    //             $acoes .= '<input type="hidden" name="_method" value="delete" />';
    //             $acoes .= '<input type="submit" class="btn btn-sm btn-danger" value="Apagar" onclick="return confirm(\'Tem certeza que deseja excluir a licitação?\')" />';
    //             $acoes .= '</form>';
    //         }
    //         return [
    //             $row->idlicitacao,
    //             $row->modalidade,
    //             $row->nrlicitacao,
    //             $row->nrprocesso,
    //             $row->situacao,
    //             formataData($row->datarealizacao),
    //             $acoes
    //         ];
    //     })->toArray();
    // }

    // public function tabelaCompleta($query)
    // {
    //     return $this->montaTabela(
    //         $this->tabelaHeaders(), 
    //         $this->tabelaContents($query),
    //         [ 'table', 'table-hover' ]
    //     );
    // }

    // public function tabelaTrashed($query)
    // {
    //     $headers = ['Código', 'Modalidade', 'Nº da Licitação', 'Deletada em:', 'Ações'];
    //     $contents = $query->map(function($row){
    //         $acoes = '<a href="'.route('licitacoes.restore', $row->idlicitacao).'" class="btn btn-sm btn-primary">Restaurar</a>';
    //         return [
    //             $row->idlicitacao,
    //             $row->modalidade,
    //             $row->nrlicitacao,
    //             formataData($row->deleted_at),
    //             $acoes
    //         ];
    //     })->toArray();

    //     return $this->montaTabela(
    //         $headers, 
    //         $contents,
    //         [ 'table', 'table-hover' ]
    //     );
    // }
}