<?php

namespace App\Http\Controllers;

use App\Models\Post;

class AuthorController extends Controller
{
    public function index()
    {

    }

    public function renderPosts() {
        $posts = Post::all();
        return view('pages.author.author_search_form', compact('posts'));
    }

    public function handleAuthorInfo() {
        return view('pages.author.author_info');
    }

    public function authorAcceptOrder() {
        return view('pages.author.author_accept_order');
    }
}
