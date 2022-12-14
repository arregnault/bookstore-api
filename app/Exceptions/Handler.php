<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (HttpException $e, $request) {
            $status = $e->getStatusCode();
            $message = Response::$statusTexts[$status];
            Log::info($e->getMessage());
            return $this->errorResponse($message, $status);
        });
        $this->renderable(function (ModelNotFoundException $e, $request) {
            Log::info($e->getMessage());
            return $this->errorResponse("No existe ningún registro con ese identificador.", Response::HTTP_NOT_FOUND);
        });
        $this->renderable(function (NotFoundHttpException $e, $request) {
            Log::info($e->getMessage());
            return $this->errorResponse("No existe ningún registro con ese identificador.", Response::HTTP_NOT_FOUND);
        });
        $this->renderable(function (AuthorizationException $e, $request) {
            Log::info($e->getMessage());
            return $this->errorResponse($e->getMessage(), Response::HTTP_FORBIDDEN);
        });
        $this->renderable(function (AuthenticateWithBasicAuth $e, $request) {
            Log::info($e->getMessage());
            return $this->errorResponse($e->getMessage(), Response::HTTP_FORBIDDEN);
        });
        $this->renderable(function (ValidationException $e, $request) {
            $errors = $e->validator->errors()->getMessages();
            Log::info($errors);
            return $this->errorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        });
    }
}
