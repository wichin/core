<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cat_sexo extends Model
{
    protected $table = 'cat_sexo';
    protected $primaryKey = 'id';

    public function Persona()
    {
        return $this->hasMany('App\Models\tb_persona','id_sexo','id');
    }
}