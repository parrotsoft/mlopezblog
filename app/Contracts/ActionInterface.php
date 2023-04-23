<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ActionInterface
{
    public static function execute(array $data, int $id = 0): Model|bool|array|Collection|null;
}
