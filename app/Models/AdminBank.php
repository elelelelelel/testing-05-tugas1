<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $account_name
 * @property string $account_number
 * @property string $account_holder
 */
class AdminBank extends Model
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
    protected $fillable = ['account_name', 'account_number', 'account_holder'];
    public $timestamps = false;

}
