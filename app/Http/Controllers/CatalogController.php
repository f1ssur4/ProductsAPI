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
        return response()->json(CatalogResource::collection($this->catalog->select()));
    }

    public function show($id, CatalogFilter $filter, Request $request)
    {
        $filter->category($id);
        return response()->json(
            CatalogResource::collection(
                $this->catalog->getFromCatalogByFilters(
                    $filter->applyFilters($request))));

//        return $this->catalog->selectByFilter($request->all());
//        $test = [
//            "products" => [
//                    0 => ['id' =>  23, 'availability' => 3, 'price' => 9414.14],
//                    1 => ['id' =>  37, 'availability' => 1, 'price' => 3454.50],
//                    2 => ['id' =>  7,  'availability' => 2, 'price' => 5436.64],
//                    3 => ['id' =>  95, 'availability' => 2, 'price' => 6765.57],
//                ],
//                "totalNumberOfFilteredItems" => 23,
//                "totalQuantityOfGoods"       => 45,
//        ];
//        return response()->json(CatalogResource::collection($this->catalog->selectByFilter([['id_brand', 4],
//            ['id_availability', 2], ['id_category', 2]])));
    }
}
