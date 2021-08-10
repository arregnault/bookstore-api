<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository
{

   /**
    * @var User
    */
    protected $user;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get all records.
     *
     * @return Collection $records
     */
    public function getAll($data = [])
    {
        $records = $this->user->filterByRole($data['role'] ?? null)
                                ->filterById($data['user_id'] ?? null)
                                ->when($data['pluck'] ?? null, function ($query, $pluck) {
                                    return $query->pluck($pluck);
                                }, function ($query) {
                                    return $query->get();
                                });
        return $records;
    }

    /**
     * Store User
     *
     * @param array $data
     * @return User $record
     */
    public function storeUser($data)
    {
        $record = $this->user::create([
            'name'               =>  $data['name'],
            'email'              =>  $data['email'],
            'password'           =>  $data['password'],
            'account_balance'    =>  $data['account_balance'],
            'role_id'            =>  $data['role_id'],
        ]);

        return $record;
    }


    /**
     * Show User
     *
     * @param integer $id
     * @return User
     */
    public function showUser($id)
    {
        $record = $this->user::findOrFail($id);

        return $record;
    }

    /**
     * Update User
     *
     * @param array $data
     * @param integer $id
     * @return User $record
     */
    public function updateUser($data, $id)
    {
        $record = $this->user::findOrFail($id);

        $record->update([
            'name'               =>  $data['name']               ?? $record->name,
            'email'              =>  $data['email']              ?? $record->email,
            'password'           =>  $data['password']           ?? $record->password,
            'account_balance'    =>  $data['account_balance']    ?? $record->account_balance,
            'role_id'            =>  $data['role_id']            ?? $record->role_id,
        ]);

        return $record->fresh();
    }

    /**
     * Delete User
     *
     * @param integer $id
     * @return User $record
     */
    public function destroyUser($id)
    {
        $record = $this->user::findOrFail($id);

        $record->delete();
    }
}
