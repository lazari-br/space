<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
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

    public function render($request, Throwable $e)
    {
        $responseTreated = $this->getHttpCodeAndMessage($e);

        $response = [
            'message' => $responseTreated['message'],
            'code' => $responseTreated['httpCode'],
        ];

        if (env('APP_ENV') == 'production') {
            return response()->json($responseTreated['message'], false, $responseTreated['httpCode']);
        } else {
            $response['file'] = $e->getFile();
            $response['line'] = $e->getLine();
            $response['trace'] = $e->getTrace();
        }

        return response()->json($response, $responseTreated['httpCode']);
    }

    private function getHttpCodeAndMessage(Throwable $exception): array
    {
        switch (true) {
            case $exception instanceof ValidationException:
                $httpCode = 400;
                $message = $exception->validator->getMessageBag()->getMessages();
                break;
            case $exception instanceof ModelNotFoundException:
                $httpCode = 401;
                $message = 'Item não existe.';
                break;
            case $exception instanceof UnauthorizedHttpException || $exception instanceof UnauthorizedException:
                $httpCode = 403;
                $message = 'Acesso não autorizado.';
                break;
            case $exception instanceof BindingResolutionException:
                $httpCode = 404;
                $message = $exception->getMessage();
                break;
            case $exception instanceof MethodNotAllowedHttpException:
                $httpCode = 405;
                $message = $exception->getMessage();
                break;
            default:
                $exceptionCode = $exception->getCode();
                $httpCode = $exceptionCode != 0 ? $exceptionCode : 500;
                $message = $exception->getMessage();
                break;
        }

        return [
            'httpCode' => $httpCode,
            'message' => $message
        ];
    }
}
