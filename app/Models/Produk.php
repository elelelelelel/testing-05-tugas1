<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'id_produk';

    protected $fillable = [
        "nama",
        "img-path",
        "jenis",
        // "isdingin",
        "harga",
    ];

    public function detailpesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'produk_id');
    }
}
