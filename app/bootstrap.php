<?php

use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\NoReturn;

if (!function_exists('successResponse')) {
    /**
     * Generate a success response in JSON format.
     *
     * @param  mixed  $data  The data to be included in the response.
     * @param  string|null  $message  The optional message to be included in the response.
     *
     * @param  int|null  $code  The HTTP status code for the response.
     * @param  bool  $log
     *
     * @return JsonResponse The JSON response.
     */
    #[NoReturn] function successResponse(mixed $data, ?string $message = null, ?int $code = 200, bool $withLog = false): JsonResponse
    {
        $result = [
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ];
        $withLog && Log::info(json_encode($result));
        return response()->json($result, $code);
    }
}

if (!function_exists('errorResponse')) {
    /**
     * Generate an error response.
     *
     * @param  mixed|null  $message  The error message (optional)
     * @param  int  $code  The status code
     * @param  mixed|null  $data  Additional data to include in the response (optional)
     *
     * @return JsonResponse The JSON response object
     */
    #[NoReturn] function errorResponse(mixed $message = null, int $code = 500, mixed $data = []): JsonResponse
    {
        $result = [
            'status' => 'error',
            'message' => $message ?? trans('helper::translate.system_error'),
            'data' => $data,
        ];
        Log::debug($message, $data);
        return response()->json($result, $code);
    }
}
