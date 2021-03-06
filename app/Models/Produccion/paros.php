<?php

namespace App\Models\Produccion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class paros extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    //relacion uno a muchos
    public function parocargas(){
        return $this->hasMany(parosCarga::class, 'paro_id');
    }

    public function grafi_arrs(){
        return $this->hasMany(grafi_arr::class, 'paro_id');
    }

    public function paroobjes(){
        return $this->hasMany(ParoObje::class, 'paro_id');
    }

    //relacion uno a muchos inversa

}
