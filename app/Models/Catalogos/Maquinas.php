<?php

namespace App\Models\Catalogos;

use App\Models\Produccion\maq_pro;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class Maquinas extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //relaciones 1 a muchos
    public function maq_pros() {
        return $this->hasMany(maq_pro::class);
    }

    public function marca(){
        return $this->hasOne(MarcasMaquinas::class, 'maquinas_id');
    }

    //relaciones uno a muchos inversa
    public function departamentos(){
        return $this->belongsTo(Departamentos::class, 'departamento_id');
    }

}
