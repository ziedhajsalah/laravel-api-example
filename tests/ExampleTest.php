<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;

    // protected $jsonHeaders = [
    //     'Content-Type' => 'application/json',
    //     'Accept' => 'application/json',
    //     '_token' => csrf_token
    // ];

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

    public function testProductCreation()
    {
        $product = factory(\App\Product::class)->make();

        $this->post(
            route('products.store'),
            $product->jsonSerialize()
        )->seeInDatabase('products', ['name' => $product->name])
            ->assertResponseOk();
    }

    public function testProductUpdate()
    {
        $product = factory(\App\Product::class)->create(['name' => 'beets']);
        $product->name = 'feets';

        $this->put(route('products.update', ['product' => $product->id]),
            $product->jsonSerialize()
        )->seeInDatabase('products', ['name' => $product->name])
            ->assertResponseOk();
    }

    public function testProductDescriptionCreation() //todo: fix this text
    {
        $product = factory(\App\Product::class)->create();
        $description = factory(\App\Description::class)->make();

        $this->post(
            route('products.descriptions.store', ['product' => $product->id]),
            $description->jsonSerialize(),
            ['_token' => csrf_token()]
        )->seeInDatabase('descriptions', ['body' => $description->body])
            ->assertResponseOk();
    }
}
