<?php

namespace App\Http\Controllers;

use App\Http\Resources\CatalogResource;
use App\Models\Catalog;
use App\Services\Filters\CatalogFilter;
use Illuminate\Http\Request;


class CatalogController extends Controller
{
    private $catalog;

    public function __construct()
    {
        $this->catalog = new Catalog();
    }

    public function index()
    {
        $products['products'] = CatalogResource::collection($this->catalog->getAll());
        $products['totalNumberOfFilteredItems'] = count($products['products']);
        $products['totalQuantityOfGoods'] = Catalog::count();
        return response()->json($products);
    }

    public function show($id, CatalogFilter $filter, Request $request)
    {
        $filter->category($id);
        $products['products'] = CatalogResource::collection($this->catalog->getInCategoryByFilters($filter->applyFilters($request)));
        $products['totalNumberOfFilteredItems'] = count($products['products']);
        $products['totalQuantityOfGoods'] = Catalog::count();
        return response()->json($products);
    }
}
