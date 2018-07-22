<?php 

namespace App\Models\Animal;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $fillable = [
        'id_grupo_animal', 'nome', 'id_fazenda', 'entrada', 'nascimento', 'nome_mae', 'nome_pai'
    ];
    protected $table = 'animal';

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
//    public function getnascimentoAttribute($value) {
 //       return \Carbon\Carbon::parse($value)->format('d/m/Y');
 //   }
//    public function getentradaAttribute($value) {
//        return \Carbon\Carbon::parse($value)->format('d/m/Y');
//    }
}
