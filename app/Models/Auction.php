<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $order_id
 * @property boolean $status
 * @property string $auction_due_at
 * @property string $created_at
 * @property string $updated_at
 * @property Order $order
 * @property AuctionDetail[] $auctionDetails
 */
class Auction extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['order_id', 'status', 'auction_due_at', 'created_at', 'updated_at'];
    public $dates = ['auction_due_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany('App\Models\AuctionDetail');
    }
}
