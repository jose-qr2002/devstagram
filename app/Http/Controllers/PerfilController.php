<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;


class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('perfil.index');
    }

    public function store(Request $request) {
        // Modificar el request
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'username' => ['required','unique:users,username,'. auth()->user()->id ,'min:3','max:20', 'not_in:editar-perfil']
        ]);


        $usuario = User::find(auth()->user()->id);

        if ($request->old_password || $request->password) {
            $this->validate($request, [
                'old_password' => 'required|min:6',
                'password' => 'required|min:6'
            ]);

            // Verificar si la contraseña actual proporcionada por el usuario coincide con la contraseña almacenada
            
            if (!Hash::check($request->old_password, $usuario->password)) {
                // La contraseña actual es válida, puedes actualizar la contraseña
                return redirect()->back()->with('mensaje', 'Contraseña Incorrecta');
            }
            $usuario->password = Hash::make($request->password);
        }



        if($request->imagen) {
            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);

            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        // Guardar cambios
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? '';
        $usuario->save();

        // Redireccionar
        return redirect()->route('post.index', $usuario->username);

    }

}
