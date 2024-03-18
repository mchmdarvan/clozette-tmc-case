<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function it_can_search_products_by_price_range()
    {
        // Create some products with different prices
        Product::factory()->create(['price' => 10000]);
        Product::factory()->create(['price' => 30000]);
        Product::factory()->create(['price' => 35000]);
        Product::factory()->create(['price' => 45000]);

        // Send a request to search products within a price range
        $response = $this->get('/api/search?price-start=30000&price-end=40000');

        // Assert that the response is successful
        $response->assertStatus(200);

        // Assert that the products within the specified price range are returned
        $response->assertJsonCount(2, 'data'); // Assuming the response contains a 'data' key with an array of products
    }
    public function it_returns_all_products()
    {
        // Assuming the ProductSeeder seeded 10 products
        $response = $this->get('/api/products');

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data');
    }
}
