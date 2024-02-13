<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class CustomHandler extends Exception
{

    //
    /**
     * Report the exception.
     *
     * @return void
     */

    public function render($request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
            return response()->json(['error' => 'Resource not found'], 404);
        }
    
        if ($exception instanceof AuthenticationException) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        if ($exception instanceof ValidationException) {
            return response()->json([
                'message' => $exception->getMessage(),
                'errors' => $exception->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new JsonResponse(
            [ 
                'errors' => true,
                'message' => $this->getMessage(),
             ], 
             $this->code
            );
    }
}
