<?php

namespace Database\Seeders;

use App\Models\AdminBank;
use App\Models\Auction;
use App\Models\AuctionDetail;
use App\Models\Order;
use App\Models\OrderLog;
use App\Models\OrderReview;
use App\Models\PriceList;
use App\Models\Setting;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i <= 10000; $i++) {
            $random = rand(0, 6);

            // Mendapatkan ID reviewer dan editor
            $editor_id = UserRole::where('role_id', 3)->pluck('user_id')->toArray();

            // Mendapatkan ID harga dan subkategori secara acak
            $price = PriceList::all();
            $sub_category_id = SubCategory::pluck('id')->toArray();

            // Mendapatkan data bank secara acak
            $bankName = ["BCA", "MANDIRI", "BRI"];
            $bank = AdminBank::where('bank_name', $bankName[array_rand($bankName)])->first();

            // Mendapatkan harga dan total kata secara acak
            $price_id = $price->random()->id;
            $price = PriceList::find($price_id)->price;
            $total_words = random_int(500, 5000);

            $total_price = $price * ceil($total_words / 1000);

            // Membuat pesanan
            $order = Order::create([
                'editor_id' => $editor_id[array_rand($editor_id)],
                'price_id' => $price_id,
                'sub_category_id' => $sub_category_id[array_rand($sub_category_id)],
                'invoice' => $this->generateInvoiceId(),
                'title' => $faker->sentence(5),
                'keyword' => $faker->sentence(2),
                'abstract' => $faker->sentence(20),
                'file_path' => '',
                'file_name' => '',
                'file_size' => '',
                'account_name' => $bank->bank_name,
                'account_number' => $bank->bank_number,
                'account_holder' => $bank->bank_holder,
                'price' => $price,
                'tax_price' => 0,
                'total_price' => $total_price,
                'payment_due' => Carbon::now()->addDays(1),
                'total_words' => $total_words,
            ]);

            $order_id = $order->id;

            // Membuat log pesanan
            OrderLog::create([
                'order_id' => $order_id,
                'log' => 'Editor Membuat Pesanan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            if ($random >= 1) {
                // Mengupdate status pembayaran dan mengunggah bukti pembayaran
                Order::where('id', $order_id)->update([
                    'paid_at' => Carbon::now()->addHours(random_int(1, 23))->addMinutes(random_int(1 , 59)),
                    'payment_proof' => $faker->imageUrl(640, 480),
                ]);

                $order = Order::find($order_id);


                OrderLog::create([
                    'order_id' => $order_id,
                    'log' => 'Editor Mengunggah Bukti Pembayaran',
                    'created_at' => $order->paid_at,
                    'updated_at' => $order->paid_at,
                ]);

                if ($random == 3 || $random == 4) {
                    // Menolak pesanan dan melakukan refund


                    Order::where('id', $order_id)->update([
                        'declined_at' => Carbon::parse($order->paid_at)->addDays(1)->addHours(random_int(1, 23))->addMinutes(random_int(1 , 59)),
                        'cancellation_reason' => 'Pesanan ditolak',
                    ]);

                    $order = Order::find($order_id);

                    OrderLog::create([
                        'order_id' => $order_id,
                        'log' => 'Makelar Menolak Pesanan',
                        'created_at' => $order->declined_at,
                        'updated_at' => $order->declined_at,
                    ]);

                    $randomRefund = rand(0, 1);

                    if ($randomRefund == 1) {
                        OrderLog::create([
                            'order_id' => $order_id,
                            'log' => 'Makelar Melakukan Refund',
                            'created_at' => Carbon::parse($order->declined_at)->addHours(1),
                            'updated_at' => Carbon::parse($order->declined_at)->addHours(1),
                        ]);
                    }
                } elseif ($random >= 2) {
                    // Mengkonfirmasi pesanan dan membuat lelang
                    Order::where('id', $order_id)->update([
                        'confirmed_at' => Carbon::parse($order->paid_at)->addDays(1)->addHours(random_int(1, 23))->addMinutes(random_int(1 , 59)),
                    ]);

                    $order = Order::find($order_id);

                    OrderLog::create([
                        'order_id' => $order_id,
                        'log' => 'Makelar Mengkonfirmasi Pesanan',
                        'created_at' => $order->confirmed_at,
                        'updated_at' => $order->confirmed_at,
                    ]);

                    if ($random >= 4) {
                        // Membuat lelang detail dan memilih reviewer
                        $order_sub_category = Order::where('id', $order_id)->first()->sub_category_id;
                        $order_editor = Order::where('id', $order_id)->first()->editor_id;


                        // Membuat lelang dengan order_id yang sama dan reviewer_id_same_subcategory secara acak
                        $auction = Auction::create([
                            'order_id' => $order_id,
                            'status' => 0,
                            'auction_due_at' => Carbon::parse($order->confirmed_at)->addDays(3),
                        ]);

                        OrderLog::create([
                            'order_id' => $order_id,
                            'log' => 'Makelar Membuat Lelang',
                            'created_at' => Carbon::parse($auction->auction_due_at),
                            'updated_at' => Carbon::parse($auction->auction_due_at)
                        ]);

                        // Mendapatkan semua data user_id dari tabel user_sub_categories
                        // dengan sub_category_id yang sama dengan $order_sub_category
                        // dan user_id tidak sama dengan $order_editor
                        $reviewer_id_same_subcategory = DB::table('user_sub_categories')
                            ->where('sub_category_id', $order_sub_category)
                            ->where('user_id', '!=', $order_editor)
                            ->pluck('user_id')
                            ->toArray();

                        // looping sebanyak jumlah reviewer_id_same_subcategory
                        // dan mengecek apa reviewer_id_same_subcategory[$j] sudah ada dengan auction_id yang sama
                        // di tabel auction_details
                        for ($j = 0; $j < count($reviewer_id_same_subcategory); $j++) {
                            // Memeriksa apakah reviewer_id_same_subcategory[$j] sudah ada dengan auction_id yang sama
                            $check = AuctionDetail::where('auction_id', $auction->id)->where('reviewer_id', $reviewer_id_same_subcategory[$j])->first();

                            // Jika belum ada, maka membuat lelang detail dengan auction_id yang sama
                            // dan reviewer_id_same_subcategory[$j] secara acak
                            if (!$check) {
                                AuctionDetail::create([
                                    'auction_id' => $auction->id,
                                    'reviewer_id' => $reviewer_id_same_subcategory[$j],
                                    'bid' => rand($total_price / 2, $total_price),
                                    'deadline_at' => Carbon::parse($auction->auction_due_at)->addDays(random_int(1, 20))->addHours(random_int(1, 23))->addMinutes(random_int(1 , 59)),
                                ]);
                            }
                        }

                        // Mendapatkan detail lelang dengan auction_id yang sama dan bid terendah
                        $auction_detail = AuctionDetail::where('auction_id', $auction->id)->orderBy('bid', 'asc')->first();


                        $random_number = random_int(0, 1);

                        if($random_number == 1) continue;

                        // Mengubah status dalam tabel auctions menjadi 1
                        Auction::where('id', $auction->id)->update([
                            'status' => 1,
                        ]);

                        // Mengubah status auction detail yang terpilih menjadi 1
                        AuctionDetail::where('id', $auction_detail->id)->update([
                            'status' => 1,
                        ]);

                        // Mengupdate informasi pada pesanan dengan informasi lelang yang terpilih
                        Order::where('id', $order_id)->update([
                            'reviewer_price' => $auction_detail->bid,
                            'deadline_at' => $auction_detail->deadline_at,
                            'start_at' => Carbon::parse($auction->auction_due_at)->addHours(random_int(1, 10))->addMinutes(random_int(1 , 59)),
                            'reviewer_id' => $auction_detail->reviewer_id,
                        ]);

                        $order = Order::find($order_id);

                        OrderLog::create([
                            'order_id' => $order_id,
                            'log' => 'Reviewer telah dipilih',
                            'created_at' => $order->start_at,
                            'updated_at' => $order->start_at,
                        ]);

                        OrderLog::create([
                            'order_id' => $order_id,
                            'log' => 'Pekerjaan Dimulai',
                            'created_at' => $order->start_at,
                            'updated_at' => $order->start_at,
                        ]);

                        if ($random >= 5) {
                            // Mengunggah dokumen review oleh reviewer

                            $upload_review_at = Carbon::parse($order->deadline_at)->subDays(random_int(1, 10))->addDays(random_int(1, 10))->addHours(random_int(1, 23))->addMinutes(random_int(1 , 59));
                            $punishment_precentage = 0;
                            $punishment = 0;

                            if ($upload_review_at > $auction_detail->deadline_at) {
                                $punishment_precentage = Setting::where('slug', 'punishment')->first()->value;
                                $punishment = $auction_detail->bid * ($punishment_precentage / 100);
                            }

                            $balance = $auction_detail->bid - $punishment;

                            Order::where('id', $order_id)->update([
                                'upload_review_at' => $upload_review_at,
                                'punishment' => $punishment,
                                'punishment_percentage' => $punishment_precentage,
                            ]);

                            $order = Order::find($order_id);

                            OrderReview::create([
                                'order_id' => $order_id,
                                'attachment_path' => $faker->imageUrl(640, 480),
                                'attachment_name' => $faker->sentence(2),
                                'attachment_size' => $faker->randomNumber(1) . ' Mb',
                            ]);

                            OrderLog::create([
                                'order_id' => $order_id,
                                'log' => 'Reviewer Mengunggah Document',
                                'created_at' => $upload_review_at,
                                'updated_at' => $upload_review_at,
                            ]);

                            $current_balance = User::where('id', $auction_detail->reviewer_id)->first()->balance;

                            User::where('id', $auction_detail->reviewer_id)->update([
                                'balance' => $current_balance + $balance,
                            ]);

                            if ($random >= 6) {
                                // Menyelesaikan pesanan
                                $done_at = Carbon::parse($order->upload_review_at)->addDays(1)->addHours(random_int(1, 23))->addMinutes(random_int(1 , 59));

                                Order::where('id', $order_id)->update([
                                    'done_at' => $done_at,
                                    'rate' => rand(1, 5),
                                    'testimonial' => $faker->sentence(10),
                                ]);

                                OrderLog::create([
                                    'order_id' => $order_id,
                                    'log' => 'Pesanan Selesai',
                                    'created_at' => $done_at,
                                    'updated_at' => $done_at,
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }

    private function generateInvoiceId()
    {
        do {
            $invoice = 'INV' . strtoupper(Str::random(8));
        } while (Order::where('invoice', $invoice)->count() > 0);
        return $invoice;
    }
}
