<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cat_estado_modulo extends Model
{
    protected $table = 'cat_estado_modulo';
    protected $primaryKey = 'id';

    public function ModuloEducativo()
    {
        return $this->hasMany('App\Models\tb_modulo_educativo','id_estado','id');
    }
}