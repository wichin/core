<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cat_estado_alumno extends Model
{
    protected $table = 'cat_estado_alumno';
    protected $primaryKey = 'id';

    public function Alumno()
    {
        return $this->hasMany('App\Models\tb_modulo_alumno','id_emodulo','id');
    }
}