<?php

namespace App\Models\Produccion\Abastos;

use App\Models\Produccion\carga;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class rela_aba_carga extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //relacion uno a muchos inversa
    public function aba_entre(){
        return $this->belongsTo(AbaEntregas::class, 'aba_entregas');
    }

    public function carga(){
        return $this->belongsTo(carga::class, 'carga_id');
    }
}
