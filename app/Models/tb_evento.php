<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_evento extends Model
{
    protected $table = 'tb_evento';
    protected $primaryKey = 'id';

    public function PersonaEvento()
    {
        return $this->hasMany('App\Models\tb_persona_evento','id_evento','id');
    }
}