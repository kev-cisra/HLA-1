<?php

namespace App\Models\Produccion;

use App\Models\Produccion\catalogos\procesos;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class grafi_arr extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //relacion uno a muchos inversa
    public function pac_graficas() {
        return $this->belongsTo(pac_grafica::class, 'pac_grafica_id');
    }

    public function paro() {
        return $this->belongsTo(paros::class, 'paro_id');
    }

    public function material() {
        return $this->belongsTo(materiales::class, 'paro_id');
    }

    public function maq_pro() {
        return $this->belongsTo(maq_pro::class, 'maq_pro_id');
    }

    public function maq_pro_linea() {
        return $this->belongsTo(maq_pro::class, 'maq_pro_linea_id');
    }

    public function proceso_id() {
        return $this->belongsTo(procesos::class, 'proceso_id');
    }

    public function proceso_linea() {
        return $this->belongsTo(procesos::class, 'proceso_linea_id');
    }
}
