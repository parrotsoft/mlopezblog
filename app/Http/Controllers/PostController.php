<?php

namespace App\Http\Controllers;

use App\Domain\Post\PostDestroyAction;
use App\Domain\Post\PostSaveAction;
use App\Domain\Post\PostUpdateAction;
use App\Http\Requests\PostRequest;
use App\ViewModels\PostViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function index()
    {
        return view('posts.index', new PostViewModel());
    }

    public function create()
    {
        return view('posts.create', new PostViewModel());
    }

    public function store(PostRequest $request)
    {
        $request->request->add([
            'user_id' => Auth::user()->getAuthIdentifier()
        ]);
        PostSaveAction::execute($request->all());
        return redirect(route('posts.index'));
    }

    public function show($id)
    {
        return view('posts.create', new PostViewModel($id));
    }

    public function update(Request $request, $id)
    {
        PostUpdateAction::execute($request->all(), $id);
        return redirect(route('posts.index'));
    }

    public function destroy($id)
    {
        PostDestroyAction::execute([], $id);
        return redirect(route('posts.index'));
    }
}
