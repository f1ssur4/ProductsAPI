<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalog;

class CatalogCurrencies extends Model
{
    use HasFactory;
    protected $table = 'catalog_currencies';

    public function catalog()
    {
        return $this->hasMany(Catalog::class, 'id_currency');
    }
}
