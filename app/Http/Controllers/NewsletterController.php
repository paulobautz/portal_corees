<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ControleController;
use App\Newsletter;
use App\Events\ExternoEvent;
use Response;
use Redirect;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $regras = [
            'nomeNl' => 'required|max:191|regex:/^[a-zA-Z ÁáÉéÍíÓóÚúÃãÕõÂâÊêÔô]+$/',
            'emailNl' => 'required|email|unique:newsletters,email',
            'celularNl' => 'required'
        ];
        $mensagens = [
            'nomeNl.required' => 'O nome é obrigatório',
            'nomeNl.regex' => 'Nome inválido',
            'emailNl.email' => 'Email inválido',
            'emailNl.required' => 'O email é obrigatório',
            'celularNl.required' => 'O celular é obrigatório',
            'emailNl.unique' => 'Este email já está cadastrado em nosso sistema'
        ];
        $validation = Validator::make($request->all(), $regras, $mensagens);
        if($validation->fails()) {
            return redirect(url()->previous().'#rodape')->withErrors($validation)->withInput($request->all());
        }

        // Remove máscara
        $celular = apenasNumeros($request->input('celularNl'));
        $nomeNl = mb_convert_case(mb_strtolower(request('nomeNl')), MB_CASE_TITLE);

        $newsletter = new Newsletter();
        $newsletter->nome = $nomeNl;
        $newsletter->email = $request->input('emailNl');
        $newsletter->celular = $celular;
        $save = $newsletter->save();
        if(!$save)
            abort(500);
        // Gera evento de inscrição no Curso
        $string = "*".$newsletter->nome."* (".$newsletter->email.")";
        $string .= " *registrou-se* na newsletter";
        event(new ExternoEvent($string));
        // Gera mensagem de agradecimento
        $agradece = "Muito obrigado por inscrever-se em nossa newsletter";
        // Retorna view de agradecimento
        return view('site.agradecimento')->with('agradece', $agradece);
    }

    public static function countNewsletter()
    {
        $contagem = Newsletter::all()->count();
        return $contagem;
    }

    public static function countNewsletterLastWeek()
    {
        $now = (new \DateTime())->modify('-7 days');
        $contagem = Newsletter::where('created_at','>=',$now)->count();
        return $contagem;
    }

    public function download()
    {
        ControleController::autorizaStatic(['1','3','2']);
        $now = date('Ymd');
        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=newsletter-'.$now.'.csv',
            'Expires' => '0',
            'Pragma' => 'public',
        ];
        $lista = Newsletter::select('email','nome','celular','created_at')->get();
        $lista = $lista->toArray();
        array_unshift($lista, array_keys($lista[0]));
        $callback = function() use($lista) {
            $fh = fopen('php://output','w');
            fprintf($fh, chr(0xEF).chr(0xBB).chr(0xBF));
            foreach($lista as $linha) {
                fputcsv($fh,$linha,';');
            }
            fclose($fh);
        };
        return Response::stream($callback, 200, $headers);
    }
}
