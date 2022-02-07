<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogCurrencies extends Model
{
    use HasFactory;
    protected $table = 'catalog_currencies';

    public function catalog()
    {
        return $this->hasMany(Catalog::class, 'id_currency');
    }

    public static function getCurrencyConvertUAH($products)
    {
        foreach ($products as $product) {
            $product->attributes['price'] = round($product->attributes['price'] * $product->currency->rate);
        }
    }
}
