<?php

namespace Tests\Unit\Http\Models;

use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function testModelIsSoftDeletable()
    {
        $product = Product::factory()->create();

        $this->assertTrue($this->isSoftDeletableModel($product));
    }

    public function testTableHasExpectedColumns()
    {
        $product = Product::factory()->create();

        $tableName = $product->getTable();
        $expectedColumns = [
            'id', 'name', 'slug', 'description', 'price', 'stock',
            'created_at', 'updated_at', 'deleted_at',
        ];

        $actualColumns = Schema::getColumnListing($tableName);

        $this->assertCount(count($expectedColumns), $actualColumns);
        $this->assertTrue(Schema::hasColumns($tableName, $expectedColumns));
    }

    public function testProductReceivesSlugBasedOnNameAndIdUponCreation()
    {
        $product = Product::factory()->create();

        $expected = sprintf('%s-%s', $product->id, Str::slug($product->name));

        $this->assertEquals($expected, $product->slug);
    }
}
