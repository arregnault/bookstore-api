<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'account_balance',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                => 'string',
        'name'              => 'string',
        'email'             => 'string',
        'account_balance'   => 'integer',
        'role_id'           => 'integer',
        'email_verified_at' => 'datetime'
    ];

    /**
     * Get the role that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    /**
     * Get all of the transactions for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(TransactionLog::class, 'user_id', 'id');
    }


    /**
     * Get all of the book reserved by the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function books()
    {
        return $this->hasManyThrough(Book::class, UserBook::class);
    }
    
    /**
     * Filter books by User id
     *
     * @var query Eloquent Query
     * @var user_id   User Id
     * @var strict Restriction flag
     */
    public function scopeFilterById($query, $user_id = null, $strict = false)
    {
        if (isset($user_id) || $strict) {
            if (is_array($user_id)) {
                return $query->whereIn('id', $user_id);
            } else {
                return $query->where('id', $user_id);
            }
        }
        return $query;
    }
    /**
     * Filter users by role name or id.
     *
     * @var query Eloquent Query
     * @var role   User role name or id
     * @var strict Restriction flag
     */
    public function scopeFilterByRole($query, $role = null, $strict = false)
    {
        if (isset($role) || $strict) {
            return $query->whereHas('role', function ($query) use ($role) {
                $query->where('name', $role)->orWhere('id', $role);
            });
        }
        return $query;
    }
}
