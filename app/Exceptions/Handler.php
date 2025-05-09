<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use \Illuminate\Http\JsonResponse;
use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e)
    {
        if ($this->mustHandleApiException($request, $e)) {

            return $this->handleApiException( $e);

        } else {

            return parent::render($request, $e);
        }
    }

    private function handleApiException(Throwable $exception): JsonResponse
    {
        $statusCode = $exception?->getCode() ?? 500;

        if (!$statusCode) {

            $statusCode = 500;
        }

        $response = [
            'message' => $statusCode == 500 ? 'Internal server error' : $exception->getMessage(),
        ];

        return response()->json($response, $statusCode);
    }

    public function mustHandleApiException($request, $exception)
    {
        $notCustomException = [
            ValidationException::class,
            AuthenticationException::class,
            AuthorizationException::class,
            HttpException::class,
        ];

        if (!$request->wantsJson()) {
            return false;
        }

        if (in_array(get_class($exception), $notCustomException)) {
            return false;
        }

        return true;
    }
}
