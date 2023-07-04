<?php

namespace App\Http\Controllers\Web;

use App\Domain\Post\PostDestroyAction;
use App\Domain\Post\PostSaveAction;
use App\Domain\Post\PostUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\ViewModels\PostViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function store(PostRequest $request): RedirectResponse
    {
        $request->request->add([
            'user_id' => Auth::user()->getAuthIdentifier(),
        ]);
        PostSaveAction::execute($request->all());

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
