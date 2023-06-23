<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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
