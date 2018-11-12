<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cat_tipo_reunion extends Model
{
    protected $table = 'cat_tipo_reunion';
    protected $primaryKey = 'id';

    public function ModuloEducativo()
    {
        return $this->hasMany('App\Models\tb_modulo_educativo','id_tipo_reunion','id');
    }
}