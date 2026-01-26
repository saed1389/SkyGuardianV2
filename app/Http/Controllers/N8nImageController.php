<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class N8nImageController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'url' => 'required|url',
            'filename' => 'required|string',
        ]);

        $url = $request->input('url');
        $filename = $request->input('filename');

        $destinationPath = public_path('uploads/blog');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        try {
            $imageContent = file_get_contents($url);
            if ($imageContent === false) {
                return response()->json(['error' => 'Failed to download image'], 500);
            }

            file_put_contents($destinationPath . '/' . $filename, $imageContent);

            return response()->json([
                'message' => 'Image saved successfully',
                'path' => '/uploads/blog/' . $filename
            ]);

        } catch (\Exception $e) {
            Log::error("n8n Image Save Error: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
