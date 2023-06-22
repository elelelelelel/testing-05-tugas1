<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $order_id
 * @property boolean $type
 * @property string $attachment_path
 * @property string $attachment_name
 * @property string $attachment_size
 * @property string $created_at
 * @property string $updated_at
 * @property Order $order
 */
class OrderReview extends Model
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
    protected $fillable = ['order_id', 'type', 'attachment_path', 'attachment_name', 'attachment_size', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
}
