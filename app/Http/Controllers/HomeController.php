<?php

namespace App\Http\Controllers;

use App\Http\Resources\Admin\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function products()
    {
        $collection = QueryBuilder::for(Product::class)
            ->allowedIncludes('photos')
            ->allowedSorts('name', 'description')
            ->defaultSort('-created_at')
            ->with('photos')
            ->getOrPaginate();

        return ProductResource::collection($collection);
    }
}
