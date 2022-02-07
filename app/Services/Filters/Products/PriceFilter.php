<?php

namespace App\Services\Filters\Products;

class PriceFilter
{

    public static function filtrate($products, $from = null, $to = null)
    {
        foreach ($products as $key => $product) {
            if ($product['price'] > $from && $product['price'] < $to){
                continue;
            }else{
                unset($products[$key]);
            }
        }
        return $products;
    }
}
