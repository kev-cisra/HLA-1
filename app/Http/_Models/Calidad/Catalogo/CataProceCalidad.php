<?php

namespace App\Models\Calidad\Catalogo;

use App\Models\Calidad\proceCalidad;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CataProceCalidad extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

 /*    //relacion uno a muchos
    public function proceCalidad(){
        return $this->hasMany(ProceCalidad::class, 'proceso_id');
    } */
}
