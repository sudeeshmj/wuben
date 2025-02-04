<?php

namespace App\Services;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Configuration\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ExceptionHandlerService
{
    public static function handleExceptions(Exceptions $exceptions)
    {
        $exceptions->render(function (AuthenticationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized Access',
            ], 401);
        });
        $exceptions->render(function (NotFoundHttpException $e) {

            return response()->json([
                'status' => false,
                'message' => 'API Route Not Found',
            ], 404);
        });

        $exceptions->render(function (ValidationException $e) {

            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $e->errors(),
            ], 422);
        });


        $exceptions->render(function (Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        });
    }
}
