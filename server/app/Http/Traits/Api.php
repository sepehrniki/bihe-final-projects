<?php

namespace App\Http\Traits;

trait Api
{
    protected function SuccessResponse($data = [])
    {
        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    protected function FailedResponse($error_code, $error = [], $status_code = 500)
    {
        return response()->json([
            'status' => false,
            'error_code' => $error_code,
            'error_messages' => $error,
        ], $status_code);
    }
}
