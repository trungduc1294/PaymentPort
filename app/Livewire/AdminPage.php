<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class AdminPage extends Component
{
    use LivewireAlert;
    public function render()
    {
        return view('livewire.admin.admin-page');
    }

    public function deleteAllPosts() {
        $posts = Post::all();
        foreach ($posts as $post) {
            $post->delete();
        }
        $this->alert('success', 'All posts deleted successfully');
    }
}
