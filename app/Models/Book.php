<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public $table = 'books';

    protected $dates = ['created_at', 'update_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'isbn',
        'publisher',
        'price',
        'year',
        'quantity',
        'user_id',
        'discount',
        'discount_ends_at',
        'is_active'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                  => 'string',
        'title'               => 'string',
        'isbn'                => 'string',
        'publisher'           => 'string',
        'price'               => 'float',
        'year'                => 'integer',
        'quantity'            => 'integer',
        'user_id'             => 'integer',
        'discount'            => 'integer',
        'discount_ends_at'    => 'date',
        'is_active'           => 'boolean',
    ];

    protected $with = [];

    protected $appends = [];


    /**
     * Get the user that owns the Book
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
