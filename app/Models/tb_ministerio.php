<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_ministerio extends Model
{
    protected $table = 'tb_ministerio';
    protected $primaryKey = 'id';

    public function PersonaMinisterio()
    {
        return $this->hasMany('App\Models\tb_persona_ministerio','id_ministerio','id');
    }
}