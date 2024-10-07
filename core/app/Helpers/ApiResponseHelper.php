<?php

if (!function_exists('apiResponse')) {
    function apiResponse($result)
    {
        return response()->json(array_filter([
            'success' => $result['status'] < 400,
            'message' => $result['message'],
            'errors' => $result['errors'] ?? null,
            'error' => $result['error'] ?? null,
            'data' => $result['data'] ?? null,
        ]), $result['status']);
    }
}
