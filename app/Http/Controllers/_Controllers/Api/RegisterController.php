<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller{

    public function register(Request $request){

        Validator::make($request->all(), [
            'name' => 'required',

            'email' => 'required|email',

            'password' => 'required',

            'c_password' => 'required|same:password',
        ])->validate();


        $input = $request->all();

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $success['token'] =  $user->createToken('MyApp')->accessToken;

        $success['name'] =  $user->name;



        return $this->sendResponse($success, 'User register successfully.');

    }

    public function login(Request $request)

    {

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

            $user = User::where('email', $request->email)->where('password', $request->password)->first();

            $success['token'] =  $user->createToken('MyApp')-> accessToken;

            $success['name'] =  $user->name;



            return $this->sendResponse($success, 'User login successfully.');

        }

        else{

            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);

        }

    }

}
