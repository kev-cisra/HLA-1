<?php

namespace App\Models\Compras\Papeleria;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class ArticulosPapeleriaRequisicion extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];
    use HasFactory;

    //relacion UNO a UNO
    public function ArticuloMaterial() {
        return $this->belongsTo(MaterialPapeleria::class, 'material_id');
    }

    //relacion muchos a uno
    public function ArticulosPapeleria() {
        return $this->belongsTo(PapeleriaRequisicion::class, 'papeleria_id');
    }
}
