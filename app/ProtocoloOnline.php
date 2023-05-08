<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProtocoloOnline extends Model
{
    //use SoftDeletes;

    protected $connection = 'mysql2';
	protected $primaryKey = 'id';
    protected $table = 'glpi_itilfollowups';
    protected $fillable = ['id', 'date', 'content', 'items_id'];

}
