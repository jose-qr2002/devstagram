<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function index() 
    {
        return view('auth.register');
    }

    public function store(Request $request) {
        //dd($request);

        //dd($request->get('username'));

        /*
            Las validaciones se hacen antes, compara los datos que estamos enviando
            Queremos que username sea un campo unico, podriamos interceptar el request
            Lo mejor seria hacer una migracion para covertir el campo username en unico
        */

        // Modificar el Request
        $request->request->add(['username' => Str::slug( $request->username )]); // Reescribe el usuario

        // Validacion
        $this->validate($request, [
            'name' => 'required|min:5',
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make( $request->password )
        ]);

        $username = $user->username;

        // Aitenticar al usuario
        auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        // Otra forma de autenticar
        // auth()->attempt($request->only('email', 'password'));

        
        // Redireccionar
        return redirect()->route('post.index', ['user' => $username]);

    }



    public function autenticar() 
    {
        return view('auth.register');
    }
}
