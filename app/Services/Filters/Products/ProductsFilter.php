<?php

namespace App\Services\Filters\Products;

use App\Models\Catalog;
use App\Services\Filters\FiltersHandler;

class ProductsFilter
{
    use FiltersHandler;

    public function __construct()
    {
        $this->query_builder = Catalog::query();
    }

    public function category($value)
    {
        return $this->query_builder->where('id_category', $value);
    }

    private function brand($value)
    {
         return $this->query_builder->where('id_brand', $value);
    }

    private function availability($value)
    {
        return $this->query_builder->where('id_availability', $value);
    }

    private function sorting($value)
    {
        if ($value['isDesc']){
            return $this->query_builder->orderBy($value['sortBy'], 'desc');
        }else{
            return $this->query_builder->orderBy($value['sortBy']);
        }
    }
}
