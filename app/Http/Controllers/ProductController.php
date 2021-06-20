<?php

namespace App\Http\Controllers;

use App\Events\ProductViewed;
use App\Filters\ProductFilter;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function one(string $slug)
    {
        $product = Product::whereSlug($slug)->with('images')->firstOrFail();

        event(new ProductViewed($product->id));

        $category = $product->category()->pluck('id')->toArray();
        $related = Product::whereHas('category', function ($query) use ($category) {
            $query->whereIn('id', $category);
        })->limit(10)->get();

        $rating = Review::where('product_id', $product->id)->pluck('rating');
        $ratingCount = count($rating);
        $rating = round($rating->avg());

        $sizes = getProductAttribute('size', $product->id);
        $colors = getProductAttribute('color', $product->id);
        $brands = getProductAttribute('brand', $product->id);

        return view('one')->with([
            'title'   => $product->name,
            'product' => $product,
            'related' => $related,
            'id'      => $product->id,
            'rating'  => $rating,
            'ratingCount'  => $ratingCount,
            'sizes' => $sizes,
            'colors' => $colors,
            'brands' => $brands,
        ]);
    }

    public function shop(ProductFilter $filters)
    {
        $products = Product::filter($filters)
            ->with('image')
            ->paginate(self::$products_per_page)
            ->appends(request()->input());

        return view('shop')->with([
            'title'   =>  'Shop page',
            'products' => $products,
            'min_price' => Product::min('price'),
            'max_price' => Product::max('price'),
        ]);
    }


    public function getTopSellingProducts(Request $request)
    {
        if ($category = $request->get('category')) {
            $products = Product::whereHas('category', function ($query) use ($category) {
                $query->where('id', $category);
            })->orderBy('total_sales', 'DESC')->paginate(8);
        } else {
            $products = Product::orderBy('total_sales', 'DESC')->paginate(8);
        }

        return view('parts.product.product-loop', [
            'products' => $products,
        ])->render();
    }
}
