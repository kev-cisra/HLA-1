<?php

namespace App\Models\Produccion\catalogos;

use App\Models\Produccion\carga_produccion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class articulos_materiales extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //relacion uno a muchos
    public function artmat_cargas(){
        return $this->hasMany(carga_produccion::class);
    }

    //relacion uno a muchos inversa
    public function artmats_material(){
        return $this->belongsTo(materiales::class, 'material_id');
    }


}
