<?php

namespace App\Helpers;

class ApiRes {
    public static function success($data = null, $message = 'Success', $statusCode = 200, $token = '', $refreshToken = '')
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
            'access_token' => $token,
            'refresh_token' => $refreshToken
        ], $statusCode);
    }

    public static function error($message = 'Error', $statusCode = 400, $errors = null)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }
}