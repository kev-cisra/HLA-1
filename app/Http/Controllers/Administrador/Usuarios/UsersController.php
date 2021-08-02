<?php

namespace App\Http\Controllers\Administrador\Usuarios;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index(){


        $users = User::orderBy('id', 'desc')
        ->paginate(5);

        return Inertia::render('Administrador/Usuarios/Usuarios', compact('users'));
    }
}
