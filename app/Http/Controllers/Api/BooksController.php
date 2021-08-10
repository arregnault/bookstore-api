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
     * Display a publishering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $result = $this->BookService->getAll($data);
        
         
            
        if (isset($result[0]) && ($result[0] instanceof Book)) {
            $result = BookResource::collection($result);
        }

        return $this->successResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Display the specified resource.
     *
     * @param  \App\Models\Books  $books
     * @return \Illuminate\Http\Response
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $books
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $books
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->BookService->destroyBook($id);

        return $this->successResponse($result);
    }

    /**
     * Make reservation of the specified resource in storage.
     *
     * @param  \App\Models\Book  $books
     * @return \Illuminate\Http\Response
     */
    public function reservation(BookReservationRequest $request, $id)
    {
        $data = $request->only(['user_id']);

        $result = $this->BookService->reserveBook($data, $id);

        return $this->successResponse($result);
    }

    /**
     * Make discount of the specified resource in storage.
     *
     * @param  \App\Models\Book  $books
     * @return \Illuminate\Http\Response
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
}
