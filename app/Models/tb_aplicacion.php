<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_aplicacion extends Model
{
    protected $table = 'tb_aplicacion';
    protected $primaryKey = 'id';

    public function Menu()
    {
        return $this->belongsTo('\App\Models\tb_menu','id_menu','id');
    }
}