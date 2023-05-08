<?php

namespace App\Repositories;

use App\ProtocoloOnline;

class ProtocoloOnlineRepository {

    public function buscaProtocoloOnline($buscaNumero)  
    {       

        $protocolos = ProtocoloOnline::where('is_private', [0])
                        ->where('items_id', [$buscaNumero]);
        
        return $protocolos->orderBy('date','DESC')->paginate(10);
    }

}