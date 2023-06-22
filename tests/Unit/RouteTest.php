<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RouteTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_home_route()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('homepage');
    }

    public function test_checkout_route()
    {
        $response = $this->get('/checkout');
        $response->assertStatus(200);
        $response->assertViewIs('checkout');
    }

    public function test_checkout_success_route()
    {
        $response = $this->get('/checkout/success');
        $response->assertStatus(200);
        $response->assertViewIs('success');
    }

}
