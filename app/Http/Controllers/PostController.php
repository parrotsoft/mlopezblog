<?php

namespace App\Http\Controllers;

use App\Domain\Post\PostDestroyAction;
use App\Domain\Post\PostSaveAction;
use App\Domain\Post\PostUpdateAction;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\User;
use App\ViewModels\PostViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class PostController extends Controller
{

    public function index(): View
    {
        return view('posts.index', new PostViewModel());
    }

    public function create(): View
    {
        return view('posts.create', new PostViewModel());
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('post/create')
                ->withErrors($validator)
                ->withInput();
        }

        $request->request->add([
            'user_id' => Auth::user()->getAuthIdentifier()
        ]);

        Post::query()->create($request->all());

        return redirect(route('posts.index'));
    }

    public function show($id): View
    {
        return view('posts.create', new PostViewModel($id));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        PostUpdateAction::execute($request->all(), $id);
        return redirect(route('posts.index'));
    }

    public function destroy($id): RedirectResponse
    {
        PostDestroyAction::execute([], $id);
        return redirect(route('posts.index'));
    }
}
