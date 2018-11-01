<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_menu extends Model
{
    protected $table = 'tb_menu';
    protected $primaryKey = 'id';

    public function Aplicacion()
    {
        return $this->hasMany('\App\Models\tb_aplicacion','id_menu','id');
    }

    public function Modulo()
    {
        return $this->belongsTo('\App\Models\tb_modulo','id_modulo','id');
    }
}