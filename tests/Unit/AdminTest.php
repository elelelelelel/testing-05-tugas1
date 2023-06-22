<?php

namespace Tests\Unit;

use Tests\TestCase;

class AdminTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_login_route()
    {
        $response = $this->get('/login');
        $response->assertStatus(200)
            ->assertViewIs('admin.login');
    }

    public function test_authentication() {
        // don't forget to seeding first for UsersTableSeeder.php
        $response = $this->post('/authenticate', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(302)
            ->assertRedirect('/admin');

    }

    public function test_logout_route() {
        $response = $this->post('/logout');

        $response->assertStatus(302)
            ->assertRedirect('/');
    }

    public function test_manage_route() {
        $response = $this->post('/authenticate', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response = $this->get('/admin/manage');
        $response->assertStatus(200)
            ->assertViewIs('admin.manage');

    }

    public function test_selling_route() {
        $response = $this->post('/authenticate', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response = $this->get('/admin/selling');
        $response->assertStatus(200)
            ->assertViewIs('admin.selling');
    }
}
