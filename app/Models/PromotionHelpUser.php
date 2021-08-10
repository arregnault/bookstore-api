<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionHelpUser extends Model
{
    use HasFactory;

    public $table = 'promotion_help_users';

    protected $dates = ['created_at', 'update_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'user_id',
        'promotion_help_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                 => 'string',
        'amount'               => 'float',
        'user_id'            => 'integer',
        'promotion_help_id'   => 'integer',
    ];

    protected $with = [];

    protected $appends = [];


    /**
     * Get the user that owns the Reservation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    
    /**
     * Get reserved book
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promotion()
    {
        return $this->belongsTo(PromotionHelpUser::class, 'promotion_help_id', 'id');
    }

    /**
     * Filter books by promotion id
     *
     * @var query Eloquent Query
     * @var user_id   Promotion Id
     * @var strict Restriction flag
     */
    public function scopeFilterByPromotion($query, $promotion_help_id = null, $strict = false)
    {
        if (isset($promotion_help_id) || $strict) {
            return $query->where('promotion_help_id', $promotion_help_id);
        }
        return $query;
    }
}
