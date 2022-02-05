<?php

namespace App\Services\Filters;

use App\Models\Catalog;

class CatalogFilter
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

    private function price($value)
    {
        return $this->query_builder->whereBetween('price', $value);
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
