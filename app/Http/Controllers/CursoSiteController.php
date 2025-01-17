<?php

namespace App\Http\Controllers;

use App\Curso;

class CursoSiteController extends Controller
{
    public function cursosAnterioresView()
    {
        $now = date('Y-m-d H:i:s');
        $cursos = Curso::where('datatermino','<',$now)
            ->where('publicado','Sim')
            ->orderBy('created_at','DESC')
            ->paginate(9);
        return response()
            ->view('site.cursos-anteriores', compact('cursos'))
            ->header('Cache-Control','no-cache');
    }

    public static function getNoticia($id)
    {
        $noticia = Curso::findOrFail($id)->noticia->first();
        if(isset($noticia))
            return $noticia->slug;
    }

    public static function checkCurso($id)
    {
        $curso = Curso::select('datatermino')
            ->findOrFail($id);
        $now = date('Y-m-d H:i:s');
        if($curso->datatermino >= $now)
            return true;
        else
            return false;
    }

    public function cursoView($id)
    {
        $curso = Curso::findOrFail($id);
        return response()
            ->view('site.curso', compact('curso'))
            ->header('Cache-Control','no-cache');
    }
}
