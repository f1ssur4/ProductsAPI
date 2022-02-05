<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;
    protected $table = 'catalog';
    private $filter;
    private $products;

    public function currency()
    {
        return $this->belongsTo(CatalogCurrencies::class, 'id_currency');
    }

    public function getAll()
    {
        return $this->all();
    }

    private function getCurrencyConvertUAH($products)
    {
        foreach ($products as $product) {
            $product->attributes['price'] *= $product->currency->rate;
        }
    }

    public function getInCategoryByFilters($query_builder)
    {
        $products = $query_builder->get();
        $this->getCurrencyConvertUAH($products);
        return $products;
    }

}
