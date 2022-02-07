<?php

namespace App\Http\Controllers;

use App\Http\Resources\CatalogResource;
use App\Models\Catalog;
use App\Services\Filters\Products\ProductsFilter;
use Illuminate\Http\Request;


class CatalogController extends Controller
{
    private $catalog;

    public function __construct()
    {
        $this->catalog = new Catalog();
    }

    public function getAll()
    {
        $products = $this->catalog->getAll();
        $products['products'] = CatalogResource::collection($products['products']);
        return response()->json($products);
    }

    public function getByFilters($idCategory, ProductsFilter $filter, Request $request)
    {
        $products = $this->catalog->getInCategoryByFilters($filter->applyFilters($idCategory, $request), $request);
        $products['products'] = CatalogResource::collection($products['products']);
        return response()->json($products);
    }
}
