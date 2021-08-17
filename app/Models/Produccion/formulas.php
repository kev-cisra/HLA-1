<?php

namespace App\Models\Produccion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class formulas extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //relacion uno a muchos

    //relacion uno a muchos inversa
    public function procesos() {
        return $this->belongsTo(procesos::class, 'proceso_id');
    }

    public function maq_pros() {
        return $this->belongsTo(maq_pro::class, 'maq_pros_id');
    }
}
