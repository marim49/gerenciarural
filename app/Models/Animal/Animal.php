<?php 

namespace App\Models\Animal;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $fillable = [
        'id_grupo_animal', 'nome', 'id_fazenda', 'entrada', 'nascimento', 'nome_mae', 'nome_pai'
    ];
    protected $table = 'animal';
    protected $append = ['entrada_convert', 'nascimento_convert'];

    public function Fazenda()
    {
        return $this->belongsTo(\App\Models\Fazenda\Fazenda::class, 'id_fazenda');
    }
    public function GrupoAnimal()
    {
        return $this->belongsTo(GrupoAnimal::class, 'id_grupo_animal');
    }
    public function HistoricoAnimal()
    {
        return $this->hasMany(HistoricoAnimal::class, 'id_animal');
    }

    //Atributos    
    public function getentradaconvertAttribute() {
       return \Carbon\Carbon::parse($this->entrada)->format('d/m/Y');
    }
    public function getnascimentoconvertAttribute() {
        if($this->nascimento)
            return \Carbon\Carbon::parse($this->nascimento)->format('d/m/Y');
        else
            return null;
    }
}
