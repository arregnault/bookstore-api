<?php

namespace App\Http\Services;

use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Http\Repositories\BookRepository;
use App\Http\Repositories\UserBookRepository;
use App\Http\Repositories\UserRepository;

use App\Events\BoughtBookEvent;
use App\Events\NewBookEvent;

use PDF;

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
     * @var $UserRepository
    */
    protected $UserRepository;



    /**
     * BookService constructor.
     *
     * @param BookRepository $BookRepository
     * @param UserBookRepository $UserBookRepository
     * @param UserRepository $UserRepository
     */
    public function __construct(BookRepository $BookRepository, UserBookRepository $UserBookRepository, UserRepository $UserRepository)
    {
        $this->BookRepository = $BookRepository;
        $this->UserBookRepository = $UserBookRepository;
        $this->UserRepository = $UserRepository;
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
            $emails = $this->UserRepository->getAll([
                'role' => 'reader',
                'pluck' => 'email'
            ]);
            event(new NewBookEvent($result, $emails));
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
            $author = $this->UserRepository->showUser($book->user_id);
            $user = auth()->user();
            $discount = 0;

            if (strtotime($book->discount_ends_at) > strtotime('now')) {
                $discount = $book->discount /  100;
            }

            $cost = $book->price - ($book->price * $discount);

            $data['cost'] = $cost;
            $reservation = $this->UserBookRepository->storeReservation($data, $id);

            
            $this->BookRepository->updateBook(['quantity' => $book->quantity - 1], $id);
            $this->UserRepository->updateUser(['account_balance' => $user->account_balance - $cost], $user->id);

            $result['reservation'] = $reservation;
            $result['user'] =   $user;
            $result['message'] = 'Reservación realizada con éxito.';

            event(new BoughtBookEvent($author, $book, $reservation));
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException($e->getMessage());
        }
        DB::commit();

        return $result;
    }

    /**
     * Make discount for a Book
     *
     * @param array $data
     * @param integer $id
     * @return String
     */
    public function discountBook($data, $id)
    {
        $result = null;
        DB::beginTransaction();
        Log::info('Hacer descuento en libro');
        try {
            $result =  $this->BookRepository->discountBook($data, $id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException($e->getMessage());
        }
        DB::commit();

        return $result;
    }

    /**
     * Generate PDF Report
     *
     * @param array $data
     * @param integer $id
     * @return String
     */

    public function pdfReportBooks()
    {
        $data = [];
        $books = $this->BookRepository->getAll(['user_id' => auth()->user()->id, 'pluck' => 'id']);
        $reservations = $this->UserBookRepository->getAllWherIneBook('book_id', $books);
        $data['books'] =  $reservations;
        $data['author'] =  auth()->user();

        
        // 'user_id' => auth()->user()->id ?? 1
        view()->share('data', $data);
        $pdf = PDF::loadView('pdf.authorBooksReport', $data);

        return $pdf->download('pdfReportBooks.pdf');
    }
}
