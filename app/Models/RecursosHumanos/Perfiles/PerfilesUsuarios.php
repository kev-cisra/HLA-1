<?php

namespace App\Models\RecursosHumanos\Perfiles;

use App\Models\Produccion\per_procs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave


class PerfilesUsuarios extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    //relacion uno a muchos
    public function perfil_perprocs() {
        return $this->hasMany(per_procs::class);
    }

    public function perfiles_jefe() {
        return $this->hasMany(PerfilesUsuarios::class);
    }

    public function jefe_perfiles() {
        return $this->hasMany(PerfilesUsuarios::class)->with('perfiles_jefe');
    }
}
