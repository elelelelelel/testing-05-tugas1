<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $editor_id
 * @property integer $reviewer_id
 * @property integer $price_id
 * @property string $invoice
 * @property string $title
 * @property string $abstract
 * @property string $keyword
 * @property string $file_path
 * @property string $file_name
 * @property string $file_size
 * @property string $account_name
 * @property string $account_number
 * @property string $account_holder
 * @property float $tax_price
 * @property float $total_price
 * @property string $payment_proof
 * @property string $payment_due
 * @property string $paid_at
 * @property string $confirmed_at
 * @property string $declined_at
 * @property string $created_at
 * @property string $updated_at
 * @property User $editor
 * @property PriceList $priceList
 * @property User $reviewer
 * @property OrderLog[] $orderLogs
 */
class Order extends Model
{
    use hasFactory;
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['editor_id', 'reviewer_id', 'price_id', 'invoice', 'title', 'abstract',
        'keyword', 'file_path', 'file_name', 'file_size', 'account_name', 'account_number',
        'testimonial', 'rate', 'revision_at', 'done_at', 'upload_review_at',
        'price', 'total_words', 'rate_admin', 'reviewer_price', 'start_at',
        'sub_category_id', 'deadline_at', 'punishment', 'punishment_percentage', 'cancellation_reason',
        'account_holder', 'tax_price', 'total_price', 'payment_proof', 'payment_due', 'paid_at',
        'form_review_path', 'form_review_name', 'form_review_size',
        'confirmed_at', 'declined_at', 'created_at', 'updated_at'];
    public $dates = ['deadline_at', 'payment_due', 'paid_at', 'confirmed_at', 'declined_at', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function editor()
    {
        return $this->belongsTo('App\Models\User', 'editor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function priceList()
    {
        return $this->belongsTo('App\Models\PriceList', 'price_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reviewer()
    {
        return $this->belongsTo('App\Models\User', 'reviewer_id');
    }

    public function auctions()
    {
        return $this->hasMany('App\Models\Auction');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany('App\Models\OrderLog');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\OrderReview');
    }

    public function subCategory()
    {
        return $this->belongsTo('App\Models\SubCategory');
    }

    public function getStatusAttribute()
    {
        if (!is_null($this->done_at)) {
            return 'Selesai';
        } else if (!is_null($this->upload_review_at)) {
            return 'Menunggu Ulasan';
        } else if (!is_null($this->declined_at)) {
            return 'Batal';
        } else if (!is_null($this->confirmed_at)) {
            if (!is_null($this->reviewer_id)) {
                return 'Dikerjakan';
            } else {
                return 'Menunggu Tawaran';
            }
        } else if (!is_null($this->paid_at)) {
            return 'Menunggu Konfirmasi';
        } else {
            return 'Nonaktif';
        }
    }
}
