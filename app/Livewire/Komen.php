<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Comment;

class Comments extends Component
{
    public $newComment = '';
    public $model; // Model yang dikomentari
    public $comments;

    public function mount($model)
    {
        $this->model = $model;
        $this->comments = $model->comments; // Mengambil komentar terkait model
    }

    public function addComment()
    {
        $this->validate([
            'newComment' => 'required|string|max:255',
        ]);

        $this->model->comments()->create([
            'body' => $this->newComment,
            'user_id' => auth()->id(),
        ]);

        $this->newComment = ''; // Mengosongkan textarea setelah menambahkan komentar
        $this->comments = $this->model->comments; // Memperbarui daftar komentar
    }

    public function render()
    {
        return view('livewire.comments');
    }
}
