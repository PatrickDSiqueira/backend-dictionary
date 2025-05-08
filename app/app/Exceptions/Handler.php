<?php

namespace App\Exceptions;
use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception): JsonResponse
    {
        // Validação
        if ($exception instanceof ValidationException) {
            return response()->json([
                'message' => 'Validation failed',
            ], 422);
        }

        // Autenticação
        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        // Not Found (404)
        if ($exception instanceof NotFoundHttpException || $exception instanceof ModelNotFoundException) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }

        // Exceções HTTP (como 404, 403, etc.)
        if ($exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();
            $message = $exception->getMessage() ?: $this->getDefaultMessage($statusCode);

            return response()->json([
                'message' => $message,
            ], $statusCode);
        }

        // Qualquer outra exceção
        $statusCode = 500;
        $message = config('app.debug') ? $exception->getMessage() : 'Internal Server Error';

        return response()->json([
            'message' => $message,
        ], $statusCode);
    }

    /**
     * Get default message for HTTP status code
     */
    private function getDefaultMessage(int $statusCode): string
    {
        return match($statusCode) {
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            422 => 'Unprocessable Entity',
            429 => 'Too Many Requests',
            500 => 'Internal Server Error',
            503 => 'Service Unavailable',
            default => 'Unknown Error',
        };
    }
}
