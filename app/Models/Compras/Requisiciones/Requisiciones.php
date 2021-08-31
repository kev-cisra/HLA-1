<?php

namespace App\Models\Compras\Requisiciones;

use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave
class Requisiciones extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    //relacion uno a muchos
    public function RequisicionesPerfil() {
        return $this->belongsTo(PerfilesUsuarios::class);
    }
}
