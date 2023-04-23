<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::all();
        $headers = [
            'ID',
            'Titulo',
            'Categoria',
            'Opción'
        ];
        $fields = [
            'id',
            'title',
            'category',
            '*'
        ];
        return view('posts.index', compact('posts', 'headers', 'fields'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->request->add([
            'user_id' => Auth::user()->getAuthIdentifier()
        ]);
        Post::query()->create($request->all());
        return redirect(route('posts.index'));
    }

    public function show($id)
    {
        $post = Post::query()->find($id);
        $categories = Category::all();
        return view('posts.create', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        Post::query()->find($id)->update($request->all());
        return redirect(route('posts.index'));
    }

    public function destroy($id)
    {
        Post::destroy($id);
        return redirect(route('posts.index'));
    }
}
