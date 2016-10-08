<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
             ->see('Laravel');
    }

    public function testProductsList()
    {
        $products = factory(\App\Product::class, 3)->create();

        $this->get(route('products.index'))
            ->assertResponseOk();

        array_map(function ($product) {
            $this->seeJson($product->jsonSerialize());
        }, $products->all());
    }

    public function testProductDescriptionsList()
    {
        $product = factory(\App\Product::class)->create();
        $product->descriptions()
            ->saveMany(factory(\App\Description::class, 3)->make());

        $this->get(route('products.descriptions.index', [
            'product' => $product->id
        ]))->assertResponseOk();

        array_map(function ($description) {
            $this->seeJson($description->jsonSerialize());
        }, $product->descriptions->all());
    }
}
