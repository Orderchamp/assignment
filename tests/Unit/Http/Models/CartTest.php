<?php

namespace Tests\Unit\Http\Models;

use App\Models\Cart;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CartTest extends TestCase
{
    public function testModelIsSoftDeletable()
    {
        $cart = Cart::factory()->create();

        $this->assertTrue($this->isSoftDeletableModel($cart));
    }

    public function testTableHasExpectedColumns()
    {
        $cart = Cart::factory()->create();

        $tableName = $cart->getTable();
        $expectedColumns = [
            'id', 'key', 'user_id', 'coupon_id', 'total', 'status',
            'created_at', 'updated_at', 'deleted_at',
        ];

        $actualColumns = Schema::getColumnListing($tableName);

        $this->assertCount(count($expectedColumns), $actualColumns);
        $this->assertTrue(Schema::hasColumns($tableName, $expectedColumns));
    }

    public function testCartReceivesKeyUponCreation()
    {
        $cart = Cart::factory()->create();

        $this->assertNotEmpty($cart->key);
    }
}
