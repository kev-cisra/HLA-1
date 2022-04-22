<?php

namespace App\Models\Calidad\Carga;

use App\Models\Calidad\Catalogo\CataMediFibras;
use App\Models\Calidad\ProceCalidad;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CargProcMeFibra extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //relacion uno a muchos
    public function proceCalidad(){
        return $this->belongsTo(ProceCalidad::class, 'proce_calidad_id');
    }

    public function cataMediFibra(){
        return $this->belongsTo(CataMediFibras::class, 'cata_medi_fibra_id');
    }

    public function perfil_me_fi(){
        return $this->belongsTo(PerfilesUsuarios::class, 'car_me_fi_perfil_id');
    }
}
