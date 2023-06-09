<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class TableComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public array $headers, public Collection $collections, public array $fields, public string $model)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table-component');
    }
}
