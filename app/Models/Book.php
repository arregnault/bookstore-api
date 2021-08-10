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

    
    
    /**
     * Filter books by title/name
     *
     * @var query Eloquent Query
     * @var title   Book  title/name
     * @var strict Restriction flag
     */
    public function scopeFilterByTitle($query, $title = null, $strict = false)
    {
        if (isset($title) || $strict) {
            return $query->where('title', 'like', "%$title%");
        }
        return $query;
    }
    
    /**
     * Filter books by author id
     *
     * @var query Eloquent Query
     * @var user_id   User Id
     * @var strict Restriction flag
     */
    public function scopeFilterByUser($query, $user_id = null, $strict = false)
    {
        if (isset($user_id) || $strict) {
            return $query->where('user_id', $user_id);
        }
        return $query;
    }
}
