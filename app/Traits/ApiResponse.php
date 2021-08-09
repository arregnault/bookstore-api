<?php


namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponse
{
    /**
     * Build a success response
     * @param string|array $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $status = Response::HTTP_OK)
    {
        return response()->json(['data' => $data], $status);
    }


    /**
     * Build a error response
     * @param string $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $status)
    {
        return response()->json(['error' => $message, 'status' => $status], $status);
    }
}
