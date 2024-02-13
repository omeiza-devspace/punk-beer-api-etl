<?php

namespace App\Traits;

trait APIResponse
{

    /**
     * Core of response
     * 
     * @param string $message
     * @param array|object|null $data
     * @param int $statusCode  
     * @param bool $isSuccess
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function coreResponse(string $message, $data = null, int $statusCode, bool $isSuccess = true)
    {
        if (!$message) {
            return response()->json(['message' => 'Message is required'], 500);
        }

        $responseData = [
            'message' => $message,
            'error' => !$isSuccess,
            'code' => $statusCode,
            'results' => $data,
        ];

        return response()->json($responseData, $statusCode);
    }

    /**
     * Send any success response
     * 
     * @param string $message
     * @param array|object|null $data
     * @param int $statusCode
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse(string $message, $data = null, int $statusCode = 200)
    {
        return $this->coreResponse($message, $data, $statusCode);
    }

    /**
     * Send any error response  
     * 
     * @param string $message
     * @param int $statusCode
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse(string $message, int $statusCode = 500)
    {
        return $this->coreResponse($message, null, $statusCode, false);
    }

    protected function handleValidationException(ValidationException $e)
    {
        $this->errorResponse( $e->getMessage(), null, 422, false);
    }

    protected function handleModelNotFoundException(ModelNotFoundException $e)
    {
        $this->errorResponse( 'Model not found', null, 404, false);
    }

    protected function handleGeneralException(\Exception $e)
    {
        $this->errorResponse( 'An error occurred while processing the data', null, 500, false);
    }
}
