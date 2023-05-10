<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface BaseApiController
{
    public function index(): Collection;

    public function store(Request $request): void;

    public function show(int $id): void;

    public function update(Request $request, int $id): void;

    public function destroy($id): void;
}
