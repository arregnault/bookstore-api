<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionHelp extends Model
{
    use HasFactory;

    public $table = 'promotion_helps';

    protected $dates = ['created_at', 'update_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'collected',
        'user_id',
        'book_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                => 'string',
        'amount'            => 'float',
        'collected'         => 'float',
        'user_id'           => 'integer',
        'book_id'           => 'integer',
    ];

    protected $with = [];

    protected $appends = [];


    
    /**
     * Get reserved book
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }
}
