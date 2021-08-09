<?php

namespace App\Http\Services;

use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Http\Repositories\BookRepository;
use App\Http\Repositories\UserBookRepository;

class BookService
{
    /**
     * @var $BookRepository
    */
    protected $BookRepository;

    /**
     * @var $UserBookRepository
    */
    protected $UserBookRepository;



    /**
     * BookService constructor.
     *
     * @param BookRepository $BookRepository
     * @param UserBookRepository $UserBookRepository
     * @param UserRepository $UserRepository
     */
    public function __construct(BookRepository $BookRepository, UserBookRepository $UserBookRepository)
    {
        $this->BookRepository = $BookRepository;
        $this->UserBookRepository = $UserBookRepository;
    }

    /**
     * Get all Books.
     *
     * @return Collection
     */
    public function getAll($data)
    {
        Log::info('Obtener listado de libros');
        return $this->BookRepository->getAll($data);
    }

    /**
     * Store Book
     * @param array $data
     * @return Model
     */
    public function storeBook($data)
    {
        $result = null;
        DB::beginTransaction();
        Log::info('Crear libro');
        try {
            $result = $this->BookRepository->storeBook($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException($e->getMessage());
        }
        DB::commit();

        return $result;
    }

    /**
    * Show Book
    *
    * @param array $data
    * @return Model
    */
    public function showBook($id)
    {
        Log::info('Obtener libro');
        return $this->BookRepository->showBook($id);
    }

    /**
     * Update Book
     *
     * @param array $data
     * @return Model
     */
    public function updateBook($data, $id)
    {
        $result = null;
        DB::beginTransaction();
        Log::info('Actualizar libro');
        try {
            $result = $this->BookRepository->updateBook($data, $id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException($e->getMessage());
        }
        DB::commit();

        return $result;
    }

    /**
     * Delete Book
     *
     * @param integer $id
     * @return String
     */
    public function destroyBook($id)
    {
        $result = null;
        DB::beginTransaction();
        Log::info('Eliminar libro');
        try {
            $this->BookRepository->destroyBook($id);
            $result = 'Libro eliminado con éxito.';
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException($e->getMessage());
        }
        DB::commit();

        return $result;
    }

    /**
     * Reserve Book
     *
     * @param array $data
     * @param integer $id
     * @return String
     */
    public function reserveBook($data, $id)
    {
        $result = null;
        DB::beginTransaction();
        Log::info('Reservar libro');
        try {
            $book = $this->BookRepository->showBook($id);
            $data['cost'] = $book->price;
            $reservation = $this->UserBookRepository->storeReservation($data, $id);
            $this->BookRepository->updateBook(['quantity' => $book->quantity - 1], $id);
            auth()->user()->update(['account_balance' => auth()->user()->account_balance - $book->price]);
            $result['reservation'] = $reservation;
            $result['user'] =  auth()->user();
            $result['message'] = 'Reservación realizada con éxito.';
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException($e->getMessage());
        }
        DB::commit();

        return $result;
    }
}
