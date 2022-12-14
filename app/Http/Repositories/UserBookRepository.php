<?php

namespace App\Http\Repositories;

use App\Models\UserBook;

class UserBookRepository
{

   /**
    * @var UserBook
    */
    protected $userbook;

    /**
     * UserBookRepository constructor.
     *
     * @param UserBook $userbook
     */
    public function __construct(UserBook $userbook)
    {
        $this->userbook = $userbook;
    }

    /**
     * Get all records.
     *
     * @return Collection $records
     */
    public function getAll($data = [])
    {
        $records = $this->userbook->get();
        return $records;
    }

    /**
     * Store UserBook
     *
     * @param array $data
     * @param integer $id
     * @return UserBook $record
     */
    public function storeReservation($data, $id)
    {
        $record = $this->userbook->create([
            'cost'            =>  $data['cost']       ?? null,
            'user_id'         =>  $data['user_id']    ?? null,
            'book_id'         =>  $data['book_id']    ?? $id,
        ]);

        return $record->fresh();
    }

    
    /**
     * Get all records where in field array.
     *
     * @return Collection $records
     */
    public function getAllWherIneBook($field, $data)
    {
        $records = $this->userbook->with(['book', 'user'])->whereIn($field, $data)->get();
        return $records;
    }
}
