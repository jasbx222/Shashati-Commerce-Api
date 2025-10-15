<?php

use App\Helpers\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

function otpRandomNumbers(): int
{
    return rand(100000, 999999);
}

function jsonResponse($data): JsonResponse
{
    return response()->json(['data'  => $data], Status::HTTP_OK);
}

function successResponse(string $message = 'success'): JsonResponse
{
    return response()->json(['message' => $message], Status::HTTP_OK);
}

function successCreateResponse(string $message = 'success'): JsonResponse
{
    return response()->json(['message' => $message], Status::HTTP_CREATED);
}


function failedResponse(array|string $errors, int $code = Status::HTTP_FORBIDDEN): JsonResponse
{
    return response()->json([
        'errors' => is_array($errors) ? $errors : [$errors],
    ], $code);
}


function errorResponse(string $message = null): JsonResponse
{
    return failedResponse($message, Status::HTTP_BAD_REQUEST);
}


function getImageUrl(?string $imagePath): ?string
{
   if ($imagePath) {
        return asset('storage/' . $imagePath);
    }
    return null;
}


function getProductUrl(?string $imagePath): ?string
{
  
    // إذا الـ path يبدأ بـ http → رجعه زي ما هو
    if (Str::startsWith($imagePath, ['http://', 'https://'])) {
        return $imagePath;
    }

    // غير كده، اعتبره path نسبي وخليه asset
    return asset('storage/' . ltrim($imagePath, '/'));
}



