<?php

namespace Tests\Browser;

use App\Models\Produk;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MenampilkanMenuMenuTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_MenampilkanSemuaMenu()
    {
        // mengambil data produk dari database
        $produks = Produk::all();

        // membuat HTTP GET ke halaman home
        $response = $this->get('/');

        // memeriksa status response
        $response->assertStatus(200);

        // memeriksa apakah elemen <li> dengan teks "All" memiliki class "uk-active" dalam response
        $response->assertSee('<li class="uk-active" uk-filter-control><a href="#" style="text-decoration: none;">All</a></li>', false);

        // memastikan semua menu sudah ditampilkan
        foreach ($produks as $produk) {

            if ($produk->isavail == 0) {
                $response->assertDontSee($produk->nama);
                $response->assertDontSee($produk->harga);
            } else {
                $response->assertSee($produk->nama);
                $response->assertSee($produk->harga);
            }
        }
    }

    public function test_MenampilkanMenuKopi()
    {
        $produksKopi = Produk::where('jenis', 1)->get();

        // membuat HTTP GET ke halaman home
        $response = $this->get('/');

        // memeriksa status response
        $response->assertStatus(200);

        // memastikan menu kopi sudah ditampilkan
        foreach ($produksKopi as $produk) {

            if ($produk->isavail == 0) {
                $response->assertDontSee($produk->nama);
                $response->assertDontSee($produk->harga);
            } else {
                $response->assertSee($produk->nama);
                $response->assertSee($produk->harga);
            }
        }

//        // Klik tombol Kopi - kopian dari halaman home pakai clickLink
//        $this->browse(function ($browser) use ($produksKopi) {
//            $browser->visitRoute('home');
//
//            // Mengambil screenshot dari tampilan saat ini
//            $browser->screenshot('screenshot_name.png'); // Ganti 'screenshot_name.png' dengan nama file yang Anda inginkan
//
//            // Lalu periksa apakah semua menu kopi sudah ditampilkan
//            foreach ($produksKopi as $produk) {
//                if ($produk->isavail == 0) {
//                    $browser->assertMissing($produk->nama)
//                        ->assertMissing($produk->harga);
//                } else {
//                    $browser->assertVisible($produk->nama)
//                        ->assertVisible($produk->harga);
//                }
//            }
//        });

    }

    public function test_MenampilkanMenuSusu()
    {
        $produksSusu = Produk::where('jenis', 2)->get();

        // membuat HTTP GET ke halaman home
        $response = $this->get('/');

        // memeriksa status response
        $response->assertStatus(200);

        // memastikan menu susu sudah ditampilkan
        foreach ($produksSusu as $produk) {

            if ($produk->isavail == 0) {
                $response->assertDontSee($produk->nama);
                $response->assertDontSee($produk->harga);
            } else {
                $response->assertSee($produk->nama);
                $response->assertSee($produk->harga);
            }
        }
    }
}
