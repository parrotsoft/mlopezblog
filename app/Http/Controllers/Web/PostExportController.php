<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Jobs\PostExportJob;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PostExportController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        dispatch(new PostExportJob($request->user()));

        return redirect(route('posts.index'));
    }
}
