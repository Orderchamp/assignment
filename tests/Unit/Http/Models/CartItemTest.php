<?php

namespace Tests\Unit\Http\Models;

use App\Models\CartItem;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CartItemTest extends TestCase
{
    public function testModelIsSoftDeletable()
    {
        $cartItem = CartItem::factory()->create();

        $this->assertTrue($this->isSoftDeletableModel($cartItem));
    }

    public function testTableHasExpectedColumns()
    {
        $cartItem = CartItem::factory()->create();

        $tableName = $cartItem->getTable();
        $expectedColumns = [
            'id', 'cart_id', 'product_id', 'price', 'quantity',
            'created_at', 'updated_at', 'deleted_at',
        ];

        $actualColumns = Schema::getColumnListing($tableName);

        $this->assertCount(count($expectedColumns), $actualColumns);
        $this->assertTrue(Schema::hasColumns($tableName, $expectedColumns));
    }
}
