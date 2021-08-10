<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    use HasFactory;

    public $table = 'transaction_logs';

    protected $dates = ['created_at', 'update_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'description',
        'user_book_id',
        'author_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'            => 'string',
        'type'          => 'string',
        'isbn'          => 'string',
        'user_book_id'  => 'string',
        'author_id'     => 'string',
        'user_id'       => 'string',
    ];

    protected $with = [];

    protected $appends = [];


    /**
     * Get the user that make the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    /**
     * Get the book associated with the TransactionLog (If any)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function book()
    {
        return $this->hasOne(Book::class, 'user_book_id', 'id');
    }

    /**
     * Get the author associated with the TransactionLog (If any)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author()
    {
        return $this->hasOne(User::class, 'author_id', 'id');
    }
}
