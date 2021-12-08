<?php

namespace App\Models\Almacen\Requisiciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class ValesSalida extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    use SoftCascadeTrait;
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];
    protected $softCascade = ['maq_pros', 'marca']; //eliminar en cascada
}
