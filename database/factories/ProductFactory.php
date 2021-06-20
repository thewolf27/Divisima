<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->realText(30),
            'img'  => self::factoryForModel(Image::class),
            'price' => $this->faker->numberBetween(1000, 9999),
            'stock' => $this->faker->randomElement(Product::PRODUCT_STOCK_STATUSES),
            'description' => $this->faker->realText(250),
            'details' => $this->faker->realText(100),
            'total_sales' => $this->faker->numberBetween(1, 9999),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $product->images()->sync(Image::factory()->count(3)->create());
        });
    }
}
