<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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

        $this->renderable(function (ValidationException $e, $request) {
            $errors = $e->validator->errors()->getMessages();

            return $this->errorResponse($errors, 422);
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            return $this->errorResponse("NOT FOUND", 404);
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            return $this->errorResponse('Unauthenticated', 401);
        });

        $this->renderable(function (AuthorizationException $e, $request) {
            return $this->errorResponse($e->getMessage(), 403);
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            return $this->errorResponse('The specified method for the request is invalid', 405);
        });

        $this->renderable(function (HttpException $e, $request) {
            return $this->errorResponse($e->getMessage(), $e->getStatusCode());
        });

        $this->renderable(function (QueryException $e, $request) {
            $errorCode = isset($e->errorInfo[1]);

            if ($errorCode == 1) {
                return $this->errorResponse('Cannot remove this resource permanently. It is related with any other resource', 409);
            }

            if (!config('app.debug')) {
                return $this->errorResponse('Unexpected Exception, Try later', 500);
            }
        });
    }
}
