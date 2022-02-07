<?php

namespace App\Models;

use App\Services\Filters\Products\PriceFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;
    protected $table = 'catalog';

    public function currency()
    {
        return $this->belongsTo(CatalogCurrencies::class, 'id_currency');
    }

    public function getAll()
    {
        $products['products'] = $this->all();
        CatalogCurrencies::getCurrencyConvertUAH($products['products']);
        $this->addCommonValues($products);
        return $products;
    }

    public function getInCategoryByFilters($query_builder, $request)
    {
        $products['products'] = $query_builder->get();
        CatalogCurrencies::getCurrencyConvertUAH($products['products']);
        $products['products'] = PriceFilter::filtrate($products['products'], $request->get('price')['from'], $request->get('price')['to']);
        $products = $this->addCommonValues($products);
        return $products;
    }

    private function addCommonValues($array)
    {
        $array['totalNumberOfFilteredItems'] = count($array['products']);
        $array['totalQuantityOfGoods'] = self::count();
        return $array;
    }

}
