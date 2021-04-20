<?php

namespace App\Traits;

trait ResponseAPI
{
    /**
     * Core of response
     * 
     * @param   string          $message
     * @param   array|object    $data
     * @param   integer         $statusCode  
     * @param   boolean         $status
     */
    public function coreResponse($message,  $statusCode, $status, $data)
    {
        // Check the params
        if (!$message) return response()->json(['message' => 'Message is required'], 500);

        return response()->json([
            'status' => $status,
            'code' => $statusCode,
            'message' => $message,
            'data' => $data
        ],$statusCode);
    }

    public function success($message ='sad', $statusCode, $data = null)
    {
        return  $this->coreResponse($message, $statusCode, $status = 'success', $data);
    }

    public function warning($message, $statusCode, $data = null)
    {
        return $this->coreResponse($message, $statusCode, 'warning', $data);
    }

    public function error($message, $statusCode, $data = null)
    {
        return $this->coreResponse($message, $statusCode, 'error', $data);
    }
}
