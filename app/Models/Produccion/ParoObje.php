<?php

namespace App\Models\Produccion;

use App\Models\obje_cordi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParoObje extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    //relacion uno a muchos inversa
    public function paro(){
        return $this->belongsTo(paros::class, 'paro_id');
    }

    public function carga(){
        return $this->belongsTo(carga::class, 'carga_id');
    }
}
