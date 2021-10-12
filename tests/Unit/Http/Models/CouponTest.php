<?php

namespace Tests\Unit\Http\Models;

use App\Models\Coupon;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CouponTest extends TestCase
{
    public function testModelIsSoftDeletable()
    {
        $coupon = Coupon::factory()->create();

        $this->assertTrue($this->isSoftDeletableModel($coupon));
    }

    public function testTableHasExpectedColumns()
    {
        $coupon = Coupon::factory()->create();

        $tableName = $coupon->getTable();
        $expectedColumns = [
            'id', 'name', 'code', 'amount', 'used',
            'created_at', 'updated_at', 'deleted_at',
        ];

        $actualColumns = Schema::getColumnListing($tableName);

        $this->assertCount(count($expectedColumns), $actualColumns);
        $this->assertTrue(Schema::hasColumns($tableName, $expectedColumns));
    }

    public function testProductReceivesCodeBasedOnIdUponCreation()
    {
        $coupon = Coupon::factory()->create();

        $this->assertNotEmpty($coupon->code);
        $this->assertStringStartsWith($coupon->id, $coupon->code);
    }
}
