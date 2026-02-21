<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class N8nImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'filename' => 'required|string',
        ]);

        $url = str_replace('&amp;', '&', $request->input('url'));
        $filename = $request->input('filename');

        $destinationPath = public_path('uploads/blog');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        try {

            $response = Http::withoutVerifying()
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept' => 'image/jpeg, image/png, image/webp, */*'
                ])
                ->timeout(60)
                ->get($url);

            if ($response->failed()) {
                Log::error("n8n API Download Error Status: " . $response->status());
                return response()->json([
                    'error' => 'Failed to download image from Pollinations',
                    'http_status' => $response->status(),
                    'api_response' => $response->body()
                ], 500);
            }

            file_put_contents($destinationPath . '/' . $filename, $response->body());

            return response()->json([
                'message' => 'Image saved successfully',
                'path' => '/uploads/blog/' . $filename
            ]);

        } catch (\Exception $e) {
            Log::error("n8n Image Save Error: " . $e->getMessage());
            return response()->json([
                'error' => 'PHP Exception Occurred',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
