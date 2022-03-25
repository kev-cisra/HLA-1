<?php

namespace App\Models\Produccion\Abastos;

use App\Models\Produccion\catalogos\claves;
use App\Models\Produccion\dep_mat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alma_Abas extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //relacion uno a muchos inversa
    public function norma() {
        return $this->belongsTo(dep_mat::class, 'norma_id');
    }

    public function clave() {
        return $this->belongsTo(claves::class, 'clave_id');
    }

    public function soli_aba() {
        return $this->belongsTo(Soli_Abas::class, 'soli_aba_id');
    }
}
