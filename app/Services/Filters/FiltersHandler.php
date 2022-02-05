<?php

namespace App\Services\Filters;

use Illuminate\Http\Request;

trait FiltersHandler
{
    public $query_builder;

    public function applyFilters(Request $request)
    {
        foreach ($request->all() as $filter_name => $value) {
            if (method_exists($this, $filter_name)){
                call_user_func_array([$this, $filter_name], [$value]);
            }
        }

        return $this->query_builder;
    }

}
