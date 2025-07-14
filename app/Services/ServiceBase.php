<?php

namespace App\Services;

use App\Contracts\ServiceContract;
use App\Services\ServiceResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

abstract class ServiceBase implements ServiceContract
{

    /**
     * To return success response of the service
     *
     * @param $result
     * @param string $message
     * @return ServiceResponse
     */
    protected static function success($result, string $message = 'ok', int $code = Response::HTTP_OK): ServiceResponse
    {

        return (new ServiceResponse($result, $message, true, $code));
    }

    /**
     * To return error response of the service
     *
     * @param $result
     * @param string $message
     * @param int $status
     * @return ServiceResponse
     */
    protected static function error($result, string $message = 'failed', int $code = Response::HTTP_BAD_REQUEST): ServiceResponse
    {
        return (new ServiceResponse($result, $message, false, $code));
    }

    protected static function catchError(\Throwable $th, mixed $errors, string $message = "Server Error"): ServiceResponse
    {
        $errorCode = 'ERR-' . now()->timestamp . '-' . \Str::random(5);

        // Log detail error
        Log::error("[$errorCode] " . $th->getMessage(), [
            'file' => $th->getFile(),
            'line' => $th->getLine(),
            'trace' => $th->getTraceAsString(),
        ]);

        // Tambahkan kode error ke message
        if (config('app.env') !== 'production') {
            $message = $th->getMessage() . " (Code: $errorCode)";
        } else {
            $message .= " (Code: $errorCode)";
        }

        return new ServiceResponse($errors, $message, false, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
