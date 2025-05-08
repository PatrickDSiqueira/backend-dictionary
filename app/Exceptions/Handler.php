<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Facades\Log;
use Exception;
class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($request->wantsJson()) {

            return $this->handleApiException($request, $exception);
        } else {
            return parent::render($request, $exception);
        }
    }

    private function handleApiException($request, Exception $exception)
    {

        $exception = $this->prepareException($exception);

        if ($exception instanceof \Illuminate\Http\Exception\HttpResponseException) {
            $exception = $exception->getResponse();
        }

        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            $exception = $this->convertValidationExceptionToResponse($exception, $request);
        }

        return $this->customApiResponse($exception);
    }

    private function customApiResponse($exception)
    {
        $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;
            
        $response = [
            'message' => ($statusCode == 500) ? 'Error message' : $exception->getMessage(),
        ];

        return response()->json($response, 400);
    }
}
