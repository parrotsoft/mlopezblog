<?php

namespace App\Contracts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface BaseApiController
{
    public function index(): AnonymousResourceCollection;

    public function store(Request $request): void;

    public function show(int $id): void;

    public function update(Request $request, int $id): void;

    public function destroy($id): void;
}
