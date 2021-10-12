<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProductTest extends TestCase
{
    private $products;

    protected function setUp(): void
    {
        parent::setUp();

        Product::getQuery()->delete();
        $this->products = Product::factory(20)->create();
    }

    public function testFetchListOfProducts()
    {
        $this->get('/api/products')
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['meta' => [
                'total' => 20,
                'current_page' => 1,
                'per_page' => 15,
                'from' => 1,
                'to' => 15,
                'last_page' => 2,
            ]])
            ->assertJsonStructure(['data' => [
                '*' =>  array_keys((new Product())->toArray())
            ]]);
    }

    public function testFetchListOfProductsWhenPageIsNotFull()
    {
        $this->get('/api/products?page=2')
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['meta' => [
                'total' => 20,
                'current_page' => 2,
                'per_page' => 15,
                'from' => 16,
                'to' => 20,
                'last_page' => 2,
            ]])
            ->assertJsonStructure(['data' => [
                '*' =>  array_keys((new Product())->toArray())
            ]]);

    }

    public function testFetchListOfProductsWhenPageIsEmpty()
    {
        $this->get('/api/products?page=3')
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                 'data' => [],
                 'meta' => [
                     'total' => 20,
                     'current_page' => 3,
                     'per_page' => 15,
                     'from' => null,
                     'to' => null,
                     'last_page' => 2,
                 ],
             ]);
    }
}
