<?php

namespace App\Http\Controllers\Administrador\Usuarios;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller{

    public function index(Request $request){

        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:id,name,email']
        ]);

        $query = User::query();

        if(request('search')){
            $query->where(request('column'), 'LIKE', '%'.request('search'). '%');
        }

        if(request()->has(['field', 'direction'])){
            $query->orderBy(request('field'), request('direction'));
        }

        return Inertia::render('Administrador/Usuarios/Usuarios', [
            'users' => $query->paginate(request('paginate')),
            'filters' => request()->all(['search','field', 'direction'])
        ]);

/*         $users = User::orderBy('id', 'desc')
        ->paginate(5);

        return Inertia::render('Administrador/Usuarios/Usuarios', [
            'users' => User::when($request->search, function($query, $search){
                $query->where('name', 'LIKE', '%'.$search.'%');
            })->paginate()
        ]); */
    }
}
