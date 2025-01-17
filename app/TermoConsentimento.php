<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TermoConsentimento extends Model
{
    protected $table = 'termos_consentimentos';
    protected $guarded = [];

    public function representante()
    {
    	return $this->belongsTo('App\Representante', 'idrepresentante');
    }

    public function newsletter()
    {
    	return $this->belongsTo('App\Newsletter', 'idnewsletter');
    }

    public function agendamento()
    {
    	return $this->belongsTo('App\Agendamento', 'idagendamento');
    }

    public function bdo()
    {
    	return $this->belongsTo('App\BdoOportunidade', 'idbdo');
    }

    public function cursoInscrito()
    {
    	return $this->belongsTo('App\CursoInscrito', 'idcursoinscrito');
    }

    public function message()
    {
        $message = 'foi criado um novo registro no termo de consentimento, com a id: '.$this->id;

        return isset($this->email) ? 'Novo email e '.$message : $message;
    }
}
