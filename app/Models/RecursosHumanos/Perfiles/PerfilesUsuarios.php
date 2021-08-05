<?php

namespace App\Models\RecursosHumanos\Perfiles;

use App\Models\Produccion\are_prof;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave


class PerfilesUsuarios extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    //relacion uno a uno inversa
    public function perfil_user() {
        return $this->belongsTo(User::class, 'IdUser');
    }
    //relacion uno a muchos
    public function perfil_areperfs() {
        return $this->hasMany(are_prof::class);
    }

    //relaciones uno a muchos inversa

    //recursividad
    public function perfiles_jefe() {
        return $this->hasMany(PerfilesUsuarios::class);
    }

    public function jefe_perfiles() {
        return $this->hasMany(PerfilesUsuarios::class)->with('perfiles_jefe');
    }

}
