<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

use Illuminate\Http\Request;
use App\Http\Requests\Books\BookStoreRequest;
use App\Http\Requests\Books\BookUpdateRequest;
use App\Http\Requests\Books\BookReservationRequest;
use App\Http\Requests\Books\BookDiscountRequest;

use App\Models\Book;
use App\Http\Services\BookService;
use App\Http\Resources\BookResource;

class BooksController extends Controller
{
    use ApiResponse;

    protected $BookService;

    public function __construct(BookService $BookService)
    {
        $this->BookService = $BookService;
    }


    /**
    * Listado de libros
    * [Obtener listado de libros y filtrarlos por nombre y orden]
    * @authenticated
    * @group  Libros
    * @urlParam  title Nombre filtro del libro
    * @urlParam  orderBy Orden por titulo (asc o desc)
    */

    public function index(Request $request)
    {
        $data = $request->only(['title', 'orderBy']);
        $result = $this->BookService->getAll($data);
        
         
            
        if (isset($result[0]) && ($result[0] instanceof Book)) {
            $result = BookResource::collection($result);
        }

        return $this->successResponse($result);
    }


    /**
    * Crear  libro
    * [Creación de libro por parte de autor]
    * @group  Libros
    * @authenticated
    * @bodyParam  title Título del libro
    * @bodyParam isbn  ISBN
    * @bodyParam publisher Editor
    * @bodyParam price Precio
    * @bodyParam year Año de Publicación
    * @bodyParam quantity Existencias
    */
    public function store(BookStoreRequest $request)
    {
        $data = $request->only([ 'title','isbn','publisher','price','year', 'quantity', 'user_id' ]);

        $result = $this->BookService->storeBook($data);


        if ($result instanceof Book) {
            $result = new BookResource($result);
        }



        return $this->successResponse($result);
    }

    /**
    * Obtener libro
    * [Obtener informaciónde un libro según su id]
    * @group  Libros
    * @authenticated
    * @urlParam  id Id del libro
    */
    public function show($id)
    {
        $result = $this->BookService->showBook($id);

        if ($result instanceof Book) {
            $result = new BookResource($result);
        }

        return $this->successResponse($result);
    }

    /**
    * Actualizar libro
    * [Actualizar información de un libro según su id]
    * @group  Libros
    * @authenticated
    * @urlParam  id Id del libro
    * @bodyParam  title Título del libro
    * @bodyParam isbn  ISBN
    * @bodyParam publisher Editor
    * @bodyParam price Precio
    * @bodyParam year Año de Publicación
    * @bodyParam quantity Existencias
    */
    public function update(BookUpdateRequest $request, $id)
    {
        $data = $request->only(['title','isbn','publisher','price','year', 'quantity']);

        $result = $this->BookService->updateBook($data, $id);

        if ($result instanceof Book) {
            $result = new BookResource($result);
        }

        return $this->successResponse($result);
    }

    
    /**
    * Eliminar libro
    * [Eliminar libro según su id]
    * @group  Libros
    * @authenticated
    * @urlParam  id Id del libro
    */
    public function destroy($id)
    {
        $result = $this->BookService->destroyBook($id);

        return $this->successResponse($result);
    }

    
    /**
    * Reservar libro
    * [Un lector reserva un libro según su id]
    * @group  Libros
    * @authenticated
    * @urlParam  id Id del libro
    */
    public function reservation(BookReservationRequest $request, $id)
    {
        $data = $request->only(['user_id']);

        $result = $this->BookService->reserveBook($data, $id);

        return $this->successResponse($result);
    }

        
    /**
    * Crear descuento para libro
    * [Un autor crea un descuento para un de sus libros según su id]
    * @group  Libros
    * @authenticated
    * @urlParam  id Id del libro
    * @bodyParam discount Porcentaje de descuento
    * @bodyParam discount_ends_at Fecha de finalización del descuento
    */
    public function discount(BookDiscountRequest $request, $id)
    {
        $data = $request->only(['discount', 'discount_ends_at']);

        $result = $this->BookService->discountBook($data, $id);

        if ($result instanceof Book) {
            $result = new BookResource($result);
        }


        return $this->successResponse($result);
    }

    /**
    * Generar reporte de libros vendidos
    * [Un autor solicita el reporte en pdf de sus libros vendidos]
    * @group  Libros
    * @authenticated
    */
    public function pdfReport()
    {
        $result = $this->BookService->pdfReportBooks();

        return $result;
    }
}
