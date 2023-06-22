<?php

namespace App\Http\Controllers;

use App\Jobs\PostExportJob;
use Illuminate\Http\Request;

class PostExportController extends Controller
{
    public function __invoke(Request $request)
    {
        PostExportJob::dispatch();
        return redirect(route('posts.index'));
        //return response()->json(['response' => 200]);
    }
}
