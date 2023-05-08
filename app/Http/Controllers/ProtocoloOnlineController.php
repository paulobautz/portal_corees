<?php

namespace App\Http\Controllers;

use App\Repositories\ProtocoloOnlineRepository;
use App\Contracts\MediadorServiceInterface;
use Illuminate\Support\Facades\Request as IlluminateRequest;

class ProtocoloOnlineController extends Controller
{
    private $ProtocoloOnlineRepository;
    private $service;

    public function __construct( ProtocoloOnlineRepository $ProtocoloOnlineRepository, MediadorServiceInterface $service) 
    {
        $this->ProtocoloOnlineRepository = $ProtocoloOnlineRepository;
        $this->service = $service;
    }

    
    public function index()
    {

        $protocolos = null;//$this->ProtocoloOnlineRepository->getToBalcaoSite();

        return view('site.protocolo', compact('protocolos'));
    }

    public function buscaProtocolo()
    {
    	$buscaNumero = IlluminateRequest::input('numero');
        $protocolosqtde = $this->ProtocoloOnlineRepository->buscaProtocoloOnline($buscaNumero);
        
        if (($buscaNumero >=1) && ((count($protocolosqtde) > 0))) {
            $protocolos = $this->ProtocoloOnlineRepository->buscaProtocoloOnline($buscaNumero);
            }       
        else {
            $protocolos = null;
        }

        return view('site.protocolo', compact('protocolos'));
    }

}
