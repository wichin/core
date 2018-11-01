<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cat_grupo extends Model
{
    protected $table = 'cat_grupo';
    protected $primaryKey = 'id';

    public function Persona()
    {
        return $this->hasMany('App\Models\tb_persona','id_grupo','id');
    }
}