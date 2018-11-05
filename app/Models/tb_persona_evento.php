<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_persona_evento extends Model
{
    protected $table = 'tb_persona_evento';
    protected $primaryKey = 'id';

    public function Persona()
    {
        return $this->belongsTo('App\Models\tb_persona','id_persona','id');
    }

    public function Evento()
    {
        return $this->belongsTo('App\Models\tb_evento','id_evento','id');
    }

    #METODOS
    public function ValidaEvento($idPersona, $idEvento)
    {
        return $this->where('id_persona',$idPersona)
            ->where('id_evento',$idEvento)
            ->where('estado',1)
            ->get();
    }

    public function SetEventoPersona($data)
    {
        return $this->insertGetId($data);
    }
}