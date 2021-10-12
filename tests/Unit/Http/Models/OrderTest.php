<?php

namespace Tests\Unit\Http\Models;

use App\Models\Order;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class OrderTest extends TestCase
{
    public function testModelIsSoftDeletable()
    {
        $order = Order::factory()->create();

        $this->assertTrue($this->isSoftDeletableModel($order));
    }

    public function testTableHasExpectedColumns()
    {
        $order = Order::factory()->create();

        $tableName = $order->getTable();
        $expectedColumns = [
            'id', 'cart_id', 'user_id', 'user_name', 'user_address',
            'created_at', 'updated_at', 'deleted_at',
        ];

        $actualColumns = Schema::getColumnListing($tableName);

        $this->assertCount(count($expectedColumns), $actualColumns);
        $this->assertTrue(Schema::hasColumns($tableName, $expectedColumns));
    }
}
