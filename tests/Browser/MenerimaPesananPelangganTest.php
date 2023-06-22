<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MenerimaPesananPelangganTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_MenerimaPesanan()
    {
        $response = $this->post('/authenticate', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response = $this->get('/admin/selling');
        $response->assertStatus(200)
            ->assertViewIs('admin.selling');

        //


    }
}
