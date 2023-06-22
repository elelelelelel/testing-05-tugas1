<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $auction_id
 * @property integer $editor_id
 * @property float $bid
 * @property string $bid_description
 * @property boolean $status
 * @property string $created_at
 * @property string $updated_at
 * @property Auction $auction
 * @property User $user
 */
class AuctionDetail extends Model
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
    protected $fillable = ['auction_id', 'reviewer_id', 'bid', 'deadline_at', 'status', 'created_at', 'updated_at'];
    public $dates = ['deadline_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function auction()
    {
        return $this->belongsTo('App\Models\Auction');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reviewer()
    {
        return $this->belongsTo('App\Models\User', 'reviewer_id');
    }

    public function getBidStatusAttribute()
    {
        if ($this->status == 1) {
            return 'Tawaran Diterima';
        } else if ($this->status == 2) {
            return 'Tawaran Ditolak';
        } else {
            return 'Tawaran Belum diundi';
        }
    }
}
