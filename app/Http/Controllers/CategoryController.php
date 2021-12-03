<?php

namespace App\Http\Controllers;

use App\Filters\ProductFilter;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function category(ProductFilter $filters, $slug): View
    {
        $category = Category::where('slug', $slug)->with('products')->firstOrFail();

        $products = Product::whereHas('category', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->filter($filters)->with('image')->paginate(self::$productsPerPage)->appends(request()->input());

        return view('shop')->with([
            'title'   =>  $category->name,
            'products' => $products,
            'minPrice' => Product::min('price'),
            'maxPrice' => Product::max('price'),
        ]);
    }
}
