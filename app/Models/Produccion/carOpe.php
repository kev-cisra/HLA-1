<?php

namespace App\Models\Produccion;

use App\Models\Produccion\catalogos\procesos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class carOpe extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //relaciones uno a muchos inversa
    public function proceso(){
        return $this->belongsTo(procesos::class, 'proceso_id');
    }
}
