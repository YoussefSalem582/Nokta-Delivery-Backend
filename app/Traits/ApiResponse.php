<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Build a standardized success response.
     */
    protected function buildResponse(string $messageKey, $data = null, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'messageKey' => $messageKey,
            'message' => [
                'en' => trans("messages.{$messageKey}", [], 'en'),
                'ar' => trans("messages.{$messageKey}", [], 'ar')
            ],
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Build a standardized error response.
     */
    protected function buildErrorResponse(string $messageKey, $errors = null, int $statusCode = 400): JsonResponse
    {
        $response = [
            'success' => false,
            'messageKey' => $messageKey,
            'message' => [
                'en' => trans("messages.{$messageKey}", [], 'en'),
                'ar' => trans("messages.{$messageKey}", [], 'ar')
            ],
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }
}
