<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CartItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product = Product::factory()->create();

        return [
            'cart_id' => Cart::factory()->create(),
            'product_id' => $product->id,
            'price' => $product->price,
            'quantity' => $this->faker->randomDigit(),
        ];
    }
}
