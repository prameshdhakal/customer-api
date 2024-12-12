<?php

namespace App\Http\Controllers;

use Exception;

class BaseController
{
    protected function getJsonInput(array $requiredKeys = [])
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        if (stripos($contentType, 'application/json') !== false) {
            $data = json_decode(file_get_contents('php://input'), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON input: ' . json_last_error_msg());
            }
        } else {
            $data = $_REQUEST;
        }

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $data)) {
                $data[$key] = null;
            }
        }

        return $data;
    }
}
