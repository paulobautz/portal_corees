<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Curso;
use App\Regional;
use App\CursoInscrito;
use App\Http\Controllers\Helper;
use App\Http\Controllers\Helpers\CursoHelper;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\CursoInscritoController;

class CursoController extends Controller
{
    public $variaveis = [
        'singular' => 'curso',
        'singulariza' => 'o curso',
        'plural' => 'curso',
        'pluraliza' => 'curso',
        'titulo_criar' => 'Cadastrar curso',
        'btn_criar' => '<a href="/admin/cursos/criar" class="btn btn-primary mr-1">Novo Curso</a>',
        'btn_lixeira' => '<a href="/admin/cursos/lixeira" class="btn btn-warning">Cursos Cancelados</a>',
        'btn_lista' => '<a href="/admin/cursos" class="btn btn-primary mr-1">Lista de Cursos</a>',
        'titulo' => 'Cursos cancelados',
    ];

    public function __construct()
    {
        $this->middleware('auth', ['except' => 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function resultados()
    {
        $resultados = Curso::orderBy('idcurso','DESC')->paginate(10);
        return $resultados;
    }

    public function tabelaCompleta($resultados)
    {
        // Opções de cabeçalho da tabela
        $headers = [
            'Turma',
            'Tipo / Tema',
            'Onde / Quando',
            'Vagas',
            'Regional',
            'Ações'
        ];
        // Opções de conteúdo da tabela
        $contents = [];
        foreach($resultados as $resultado) {
            $acoes = '<a href="/curso/'.$resultado->idcurso.'" class="btn btn-sm btn-default" target="_blank">Ver</a> ';
            $acoes .= '<a href="/admin/cursos/inscritos/'.$resultado->idcurso.'" class="btn btn-sm btn-secondary">Inscritos</a> ';
            $acoes .= '<a href="/admin/cursos/editar/'.$resultado->idcurso.'" class="btn btn-sm btn-primary">Editar</a> ';
            $acoes .= '<form method="POST" action="/admin/cursos/cancelar/'.$resultado->idcurso.'" class="d-inline">';
            $acoes .= '<input type="hidden" name="_token" value="'.csrf_token().'" />';
            $acoes .= '<input type="hidden" name="_method" value="delete" />';
            $acoes .= '<input type="submit" class="btn btn-sm btn-danger" value="Cancelar" onclick="return confirm(\'Tem certeza que deseja cancelar o curso?\')" />';
            $acoes .= '</form>';
            $conteudo = [
                $resultado->idcurso,
                $resultado->tipo.'<br>'.$resultado->tema,
                $resultado->endereco.'<br />'.Helper::formataData($resultado->datarealizacao),
                CursoHelper::contagem($resultado->idcurso).' / '.$resultado->nrvagas,
                $resultado->regional->regional,
                $acoes
            ];
            array_push($contents, $conteudo);
        }
        // Classes da tabela
        $classes = [
            'table',
            'table-hover'
        ];
        // Monta e retorna tabela        
        $tabela = CrudController::montaTabela($headers, $contents, $classes);
        return $tabela;
    }

    public function index(Request $request)
    {
        $request->user()->autorizarPerfis(['admin', 'editor']);
        $resultados = $this->resultados();
        $tabela = $this->tabelaCompleta($resultados);
        $variaveis = (object) $this->variaveis;
        return view('admin.crud.home', compact('tabela', 'variaveis', 'resultados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->autorizarPerfis(['admin', 'editor']);
        $variaveis = (object) $this->variaveis;
        $regionais = Regional::all();
        return view('admin.crud.criar', compact('variaveis', 'regionais'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->autorizarPerfis(['admin', 'editor']);
        $regras = [
            'tema' => 'required',
            'datarealizacao' => 'required',
            'endereco' => 'required',
            'nrvagas' => 'required|numeric',
            'descricao' => 'required'
        ];
        $mensagens = [
            'required' => 'O :attribute é obrigatório',
            'numeric' => 'O :attribute aceita apenas números'
        ];
        $erros = $request->validate($regras, $mensagens);

        $curso = New Curso();
        $curso->tipo = $request->input('tipo');
        $curso->tema = $request->input('tema');
        $curso->datarealizacao = $request->input('datarealizacao');
        $curso->datatermino = $request->input('datatermino');
        $curso->endereco = $request->input('endereco');
        $curso->img = $request->input('img');
        $curso->nrvagas = $request->input('nrvagas');
        $curso->idregional = $request->input('idregional');
        $curso->descricao = $request->input('descricao');
        $curso->resumo = $request->input('resumo');
        $curso->idusuario = $request->input('idusuario');
        $save = $curso->save();
        if(!$save)
            abort(500);
        return redirect()->route('cursos.lista');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->autorizarPerfis(['admin', 'editor']);
        $resultado = Curso::find($id);
        $regionais = Regional::all();
        $variaveis = (object) $this->variaveis;
        return view('admin.crud.editar', compact('resultado', 'regionais', 'variaveis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->autorizarPerfis(['admin', 'editor']);
        $regras = [
            'tema' => 'required',
            'datarealizacao' => 'required',
            'endereco' => 'required',
            'nrvagas' => 'required|numeric',
            'descricao' => 'required'
        ];
        $mensagens = [
            'required' => 'O :attribute é obrigatório',
            'numeric' => 'O :attribute aceita apenas números'
        ];
        $erros = $request->validate($regras, $mensagens);

        $curso = Curso::find($id);
        $curso->tipo = $request->input('tipo');
        $curso->tema = $request->input('tema');
        $curso->datarealizacao = $request->input('datarealizacao');
        $curso->datatermino = $request->input('datatermino');
        $curso->endereco = $request->input('endereco');
        $curso->img = $request->input('img');
        $curso->nrvagas = $request->input('nrvagas');
        $curso->idregional = $request->input('idregional');
        $curso->descricao = $request->input('descricao');
        $curso->resumo = $request->input('resumo');
        $curso->idusuario = $request->input('idusuario');
        $update = $curso->update();
        if(!$update)
            abort(500);
        return redirect()->route('cursos.lista');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $request->user()->autorizarPerfis(['admin', 'editor']);
        $curso = Curso::find($id);
        $delete = $curso->delete();
        if(!$delete)
            abort(500);
        return redirect()->route('cursos.lista');
    }

    /**
     * Mostra a lixeira de cursos
     *
     * @return \Illuminate\Http\Response
     */
    public function lixeira(Request $request)
    {
        $request->user()->autorizarPerfis(['admin', 'editor']);
        $resultados = Curso::onlyTrashed()->paginate(10);
        // Opções de cabeçalho da tabela
        $headers = [
            'Turma',
            'Tipo / Tema',
            'Onde / Quando',
            'Regional',
            'Cancelado em:',
            'Ações'
        ];
        // Opções de conteúdo da tabela
        $contents = [];
        foreach($resultados as $resultado) {
            $acoes = '<a href="/admin/cursos/restore/'.$resultado->idcurso.'" class="btn btn-sm btn-primary">Restaurar</a> ';
            $conteudo = [
                $resultado->idcurso,
                $resultado->tipo.'<br>'.$resultado->tema,
                $resultado->endereco.'<br />'.Helper::formataData($resultado->datarealizacao),
                $resultado->regional->regional,
                Helper::formataData($resultado->deleted_at),
                $acoes
            ];
            array_push($contents, $conteudo);
        }
        // Classes da tabela
        $classes = [
            'table',
            'table-hover'
        ];
        // Monta e retorna tabela
        $variaveis = (object) $this->variaveis; 
        $tabela = CrudController::montaTabela($headers, $contents, $classes);
        return view('admin.crud.lixeira', compact('tabela', 'variaveis', 'resultados'));
    }

    /**
     * Restaura licitação deletada
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $request->user()->autorizarPerfis(['admin', 'editor']);
        $curso = Curso::onlyTrashed()->find($id);
        $curso->restore();
        return redirect()->route('cursos.lista');
    }

    public function inscritos(Request $request, $id)
    {
        $request->user()->autorizarPerfis(['admin', 'editor']);
        $resultados = CursoInscrito::where('idcurso', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $curso = Curso::find($id);
        $variaveis = [
            'pluraliza' => 'inscritos',
            'plural' => 'inscritos',
            'singular' => 'inscrito',
            'singulariza' => 'o inscrito',
            'continuacao_titulo' => 'em '.$curso->tipo.': '.$curso->tema,
            'btn_criar' => '<a href="/admin/cursos/adicionar-inscrito/'.$curso->idcurso.'" class="btn btn-primary mr-1">Adicionar inscrito</a> ',
            'btn_lixeira' => '<a href="/admin/cursos" class="btn btn-default">Lista de Cursos</a>'
        ];
        $tabela = CursoInscritoController::tabelaCompleta($resultados);
        $variaveis = (object) $variaveis;
        return view('admin.crud.home', compact('tabela', 'variaveis', 'resultados'));
    }

    public function busca()
    {
        $busca = Input::get('q');
        $cursos = Curso::where('tipo','LIKE','%'.$busca.'%')
            ->orWhere('tema','LIKE','%'.$busca.'%')
            ->orWhere('descricao','LIKE','%'.$busca.'%')
            ->paginate(10);
        if (count($cursos) > 0) 
            return view('admin.cursos.home', compact('cursos', 'busca'));
        else
            return view('admin.cursos.home')->withMessage('Nenhum curso encontrado');
    }
}
