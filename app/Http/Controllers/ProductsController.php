<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    private $catalog;

    public function __construct()
    {
        $this->catalog = new Catalog();
    }
    public function index(Request $request)
    {
        return response()->json($this->catalog->select()->get());
    }
}
