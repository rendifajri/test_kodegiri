<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\RouteNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        $this->renderable(function (Throwable $e) {
            if ($e instanceof AuthenticationException) {
                return response(['success' => false, 'message' => $e->getMessage(), 'errors' => null, 'data' => null], 401);
            }
            else if ($e instanceof \AccessDeniedHttpException) {
                return response(['success' => false, 'message' => $e->getMessage(), 'errors' => null, 'data' => null], 403);
            }
            else if ($e instanceof HttpException) {
                return response(['success' => false, 'message' => $e->getMessage(), 'errors' => null, 'data' => null], 403);
            }
            else if ($e instanceof HttpException) {
                return response(['success' => false, 'message' => $e->getMessage(), 'errors' => null, 'data' => null], 403);
            }
            else if ($e instanceof NotFoundHttpException) {
                return response(['success' => false, 'message' => $e->getMessage(), 'errors' => null, 'data' => null], 404);
            }
            else if ($e instanceof RouteNotFoundException) {
                return response(['success' => false, 'message' => $e->getMessage(), 'errors' => null, 'data' => null], 404);
            }
            else if ($e instanceof \ValidationException) {
                return response(['success' => false, 'message' => $e->errors(), 'errors' => $e->validator->getData(), 'data' => null], 400);
            }
            // else {
                // echo get_class($e);
                // return response(['success' => false, 'message' => $e->getMessage(), 'errors' => null, 'data' => null], $e->getStatusCode());
            // }
        });
    }
}
