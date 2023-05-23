<?php

namespace App\Http\Controllers\Api;

// use Illuminate\Http\Request;
use App\Http\Requests\{
    LoginRequest,
    RegistarRequest
};
use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Http\Resources\UserResource;
use Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;

class ContaController extends Controller
{
    /** Endpoint Login */
    public function login(LoginRequest $request)
    {
        // validar
        // efectuar login
        if (!Auth::attempt($request->only('email','password')))
        {
            Helper::sendError('Email ou palavra-passe estão incorrectas.');
        }
        //enviar resposta
        return new UserResource(auth()->user());
    }

    /** Emdpoint Register */
    public function registar(RegistarRequest $request)
    {
        // validar
        // registar
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password)
        ]);

        // atribuir permissões de usuário
        $user_role = Role::whereName('user')->first();
        if ($user_role)
        {
            $user->assignRole($user_role);
        }
        //enviar Resposta
        return new UserResource($user);
    }
}
