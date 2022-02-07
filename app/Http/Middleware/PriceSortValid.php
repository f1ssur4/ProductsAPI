<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PriceSortValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $validator = Validator::make($request->all(), [
            'brand' => 'integer',
            'availability' => 'integer',
            'price' => 'array|required',
            'price.from' => 'integer|required',
            'price.to' => 'integer|required',
            'sorting' => 'array|required',
            'sorting.sortBy' => ' ends_with:name,price|required',
            'sorting.isDesc' => 'boolean|required',
        ]);

        if ($validator->fails()) {
            return response('False', 400);
        }else{
            return $next($request);
        }
    }
}
