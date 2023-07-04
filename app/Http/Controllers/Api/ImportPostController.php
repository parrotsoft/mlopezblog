<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\PostImportJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImportPostController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        if(empty($request->file('file'))) {
            return response()->json(['message' => 'A file is required'], 400);
        }

        $file = $request->file('file')->store('imports');

        dispatch(new PostImportJob($file, $request->user()));

        return response()->json([
            'message' => 'The importation has been started',
        ]);
    }
}
