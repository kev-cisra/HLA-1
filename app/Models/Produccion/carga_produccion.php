<?php

namespace App\Models\Produccion;

use App\Models\Produccion\catalogos\articulos_materiales;
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
        return $this->belongsTo(articulos_materiales::class, 'articulo_id');
    }

    public function cargas_turno() {
        return $this->belongsTo(turnos::class, 'turno_id');
    }

    public function cargas_perproc() {
        return $this->belongsTo(per_procs::class, 'per_proc_id');
    }
}
