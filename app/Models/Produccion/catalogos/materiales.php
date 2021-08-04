<?php

namespace App\Models\Produccion\catalogos;

use App\Models\RecursosHumanos\Catalogos\Areas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class materiales extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //relacion uno a muchos
    public function material_artmats(){
        return $this->hasMany(materiales::class);
    }

    public function materiales_area() {
        return $this->belongsTo(Areas::class, 'area_id');
    }
}
