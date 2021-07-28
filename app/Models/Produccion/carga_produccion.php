<?php

namespace App\Models\Produccion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class carga_produccion extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //relaciones uno a muchos inversas
    public function cargas_artmat(){
        return $this->belongsTo('App\Models\Produccion\catalogos\articulos_materiales', 'articulo_id');
    }

    public function cargas_turno() {
        return $this->belongsTo('App\Models\Produccion\turnos', 'turno_id');
    }

    public function cargas_perproc() {
        return $this->belongsTo('App\Models\Produccion\per_procs', 'per_proc_id');
    }
}
