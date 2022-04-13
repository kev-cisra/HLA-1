<?php

namespace App\Models\Calidad\Catalogo;

use App\Models\Calidad\Carga\CargProcMeFibra;
use App\Models\Produccion\catalogos\claves;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CataMediFibras extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //relacion uno a muchos
    public function clave(){
        return $this->hasMany(claves::class, 'clave_id');
    }

    //relacion unoa muchos inversa
    public function carg_mefibra(){
        return $this->hasMany(CargProcMeFibra::class, 'cata_medi_fibra_id');
    }
}
