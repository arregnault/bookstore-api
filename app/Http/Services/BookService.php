<?php

namespace App\Http\Services;

use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Http\Repositories\BookRepository;

class BookService
{
    /**
     * @var $BookRepository
    */
    protected $BookRepository;


    /**
     * BookService constructor.
     *
     * @param BookRepository $BookRepository
     */
    public function __construct(BookRepository $BookRepository)
    {
        $this->BookRepository = $BookRepository;
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
}
