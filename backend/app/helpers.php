<?php

use Illuminate\Http\Response;

if (!function_exists('json_response')) {
    /**
     * Send a JSON response
     * 
     * @param mixed $data Response data
     * @param int $statusCode HTTP status code
     * @param bool $success Indicates success or failure
     * @param string|null $message Optional response message
     * @return Response
     */
    function json_response($data = [], int $statusCode = 200, bool $success = true, ?string $message = null): Response
    {
        $response = [
            'success' => $success,
            'message' => $message,
            'payload'    => $data,
        ];

        return new Response($response, $statusCode);
    }
}

if (!function_exists('generate_token')) {
    function generate_token($sessionUser)
    {
        return md5(uniqid($sessionUser, true));
    }
}
