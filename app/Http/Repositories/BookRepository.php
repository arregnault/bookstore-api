<?php

namespace App\Http\Repositories;

use App\Models\Book;

class BookRepository
{

   /**
    * @var Book
    */
    protected $book;

    /**
     * BookRepository constructor.
     *
     * @param Book $book
     */
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * Get all records.
     *
     * @return Collection $records
     */
    public function getAll()
    {
        $records = $this->book->get();
        return $records;
    }

    /**
     * Store Book
     *
     * @param array $data
     * @return Book $record
     */
    public function storeBook($data)
    {
        $record = $this->book::create([
            'title'           =>  $data['title'],
            'isbn'            =>  $data['isbn'],
            'publisher'       =>  $data['publisher'],
            'price'           =>  $data['price'],
            'year'            =>  $data['year'],
            'quantity'        =>  $data['quantity'],
            'user_id'         =>  $data['user_id'],
        ]);

        return $record;
    }


    /**
     * Show Book
     *
     * @param integer $id
     * @return Book
     */
    public function showBook($id)
    {
        $record = $this->book::findOrFail($id);

        return $record;
    }

    /**
     * Update Book
     *
     * @param array $data
     * @param integer $id
     * @return Book $record
     */
    public function updateBook($data, $id)
    {
        $record = $this->book::findOrFail($id);

        $record->update([
            'title'           =>  $data['title']      ?? $record->title,
            'isbn'            =>  $data['isbn']       ?? $record->isbn,
            'publisher'       =>  $data['publisher']  ?? $record->publisher,
            'price'           =>  $data['price']      ?? $record->price,
            'year'            =>  $data['year']       ?? $record->year,
            'quantity'        =>  $data['quantity']   ?? $record->quantity,
            'user_id'         =>  $data['user_id']    ?? $record->user_id,
        ]);

        return $record->fresh();
    }

    /**
     * Delete Book
     *
     * @param integer $id
     * @return Book $record
     */
    public function destroyBook($id)
    {
        $record = $this->book::findOrFail($id);

        $record->delete();
    }
}
