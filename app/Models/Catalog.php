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

    public function Currency()
    {
        return $this->belongsTo(CatalogCurrencies::class, 'id_currency');
    }

    public function select()
    {
        return $this->all();
    }

    private function currencyConvert(int $price, int $rate)
    {
        return $price * $rate;
    }

    public function getFromCatalogByFilters($query_builder)
    {
        return $query_builder->get();
    }



}
