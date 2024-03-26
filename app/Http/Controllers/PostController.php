<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
    }

    public function index(User $user) {
        $posts = Post::where('user_id', $user->id)->latest()->paginate(2);


        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create() {
        return view('posts.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'titulo' => 'required:max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);
        /*
        Post::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);
        */
        // Otra forma de crera registros
        /*
        $post = new Post;
        $post->titulo = $request->titulo;
        $post->descripcion = $request->descripcion;
        $post->imagen = $request->imagen;
        $post->user_id = auth()->user()->id;
        $post->save();
        */



        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
        ]);

        return redirect()->route('post.index', auth()->user()->username);
    }
    
    public function show(User $user, Post $post) {
        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

    public function destroy(Post $post) {
        // Verifica que el usuario sea el mismo que
        // publico el post para autorizar las acciones del controlador
        $this->authorize('delete', $post); 
        $post->delete(); // Elimna la publicacion

        // Eliminar la imagen
        $imagen_path = public_path('uploads/' . $post->imagen); // Construimos el path

        if(File::exists($imagen_path)) { // Verificamos que exista en nuestro path
            unlink($imagen_path); // Eliminamos el archivo
        }

        return redirect()->route('post.index', auth()->user()->username); // Redirecciona al usuario
    }
}
