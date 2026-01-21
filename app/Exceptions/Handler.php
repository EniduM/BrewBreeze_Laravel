<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // Handle API requests with JSON responses
        if ($request->expectsJson() || $request->is('api/*')) {
            return $this->handleApiException($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Handle API exceptions with standardized JSON responses.
     */
    protected function handleApiException($request, Throwable $exception): JsonResponse
    {
        // Log the exception
        Log::channel('api')->error('API Exception', [
            'exception' => get_class($exception),
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'user_id' => $request->user()?->id,
        ]);

        // Handle specific exception types
        if ($exception instanceof ValidationException) {
            return $this->handleValidationException($exception);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->handleAuthenticationException($exception);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found',
                'error' => 'The requested resource could not be found.',
            ], 404);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'success' => false,
                'message' => 'Method not allowed',
                'error' => 'The HTTP method used is not allowed for this endpoint.',
            ], 405);
        }

        if ($exception instanceof QueryException) {
            // Don't expose database errors in production
            $message = config('app.debug') 
                ? $exception->getMessage() 
                : 'A database error occurred. Please try again later.';

            return response()->json([
                'success' => false,
                'message' => 'Database error',
                'error' => $message,
            ], 500);
        }

        // Generic error response
        $statusCode = method_exists($exception, 'getStatusCode') 
            ? $exception->getStatusCode() 
            : 500;

        return response()->json([
            'success' => false,
            'message' => 'An error occurred',
            'error' => config('app.debug') 
                ? $exception->getMessage() 
                : 'An unexpected error occurred. Please try again later.',
        ], $statusCode);
    }

    /**
     * Handle validation exceptions.
     */
    protected function handleValidationException(ValidationException $exception): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $exception->errors(),
        ], 422);
    }

    /**
     * Handle authentication exceptions.
     */
    protected function handleAuthenticationException(AuthenticationException $exception): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Unauthenticated',
            'error' => 'Authentication required. Please provide a valid token.',
        ], 401);
    }
}
