<?php

namespace App\Livewire;

use App\Models\Comentario;
use Livewire\Component;

class ComentarioPost extends Component
{   
    public $comentarios;
    public $comentario;
    public $post;
    public $mensaje;

    public function mount($post) {
        $this->post = $post;
        $this->comentarios = $post->comentarios;
    }

    public function comentar() {
        $this->validate([
            'comentario' => 'required|max:255'
        ]);
        
        $newComment = Comentario::create([
            'user_id' => auth()->user()->id,
            'post_id' => $this->post->id,
            'comentario' => $this->comentario
        ]);

        $this->comentarios->push($newComment);
        $this->reset('comentario');
    }

    public function render()
    {
        return view('livewire.comentario-post');
    }
}
