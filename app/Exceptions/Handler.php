<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Exceptions\MissingScopeException;
use Throwable;

class Handler extends ExceptionHandler
{
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*') || $request->wantsJson()) {
            if ($exception->getMessage() == "Unauthenticated.") {
                return sendError('Unauthenticated.', [$exception->getMessage()], 401);
            }
            if ($exception instanceof AuthenticationException) {
                return sendError('Unauthenticated.', [$exception->getMessage()], 401);
            }
            if ($exception instanceof HttpException) {
                return sendError($exception->getMessage(), [$exception->getMessage()], $exception->getStatusCode());
            }
            if ($exception instanceof ValidationException) {
                return sendError('Failed Operation', ['Failed Operation'], 422);
            }
            if ($exception instanceof UnauthorizedException) {
                return sendError($exception->getMessage(), [$exception->getMessage()], 403);
            }
            if ($exception instanceof MissingScopeException) {
                return sendError($exception->getMessage(), [$exception->getMessage()], 403);
            }
            if (App::environment('local')) {
                return sendError('Failed Operation Contact Technical Support', [$exception->getMessage()], 500);
            } else {
                return sendError('Failed Operation Contact Technical Support', ['Failed Operation Contact Technical Support'], 500);
            }
        }
        if ($exception instanceof UnauthorizedException) {
            return abort(403);
        }
        return parent::render($request, $exception);
    }
}
