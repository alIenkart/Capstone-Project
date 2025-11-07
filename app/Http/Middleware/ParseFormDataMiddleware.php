<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ParseFormDataMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Only process PATCH, PUT, DELETE requests with multipart/form-data
        if (in_array($request->getMethod(), ['PATCH', 'PUT', 'DELETE']) && 
            str_contains($request->header('Content-Type') ?? '', 'multipart/form-data')) {
            
            $this->parseFormData($request);
        }

        return $next($request);
    }

    protected function parseFormData(Request $request)
    {
        $input = $request->getContent();
        $contentType = $request->header('Content-Type');
        
        \Log::info('Middleware - Content-Type: ' . $contentType);
        \Log::info('Middleware - Raw input length: ' . strlen($input));
        
        if (!preg_match('/boundary=([^;\r\n]+)/', $contentType, $matches)) {
            \Log::error('Middleware - Could not extract boundary');
            return;
        }
        
        $boundary = trim($matches[1], '"');
        \Log::info('Middleware - Boundary: ' . $boundary);
        
        $data = [];
        
        // Split by boundary
        $blocks = preg_split('/-+' . preg_quote($boundary) . '/', $input);
        \Log::info('Middleware - Total blocks: ' . count($blocks));
        
        foreach ($blocks as $index => $block) {
            \Log::info('Middleware - Processing block ' . $index . ', length: ' . strlen($block));
            
            if (empty(trim($block)) || $block === '--') {
                \Log::info('Middleware - Skipping empty block');
                continue;
            }
            
            // Split headers from content
            if (strpos($block, "\r\n\r\n") === false) {
                \Log::info('Middleware - No header/content separator found');
                continue;
            }
            
            list($headerBlock, $contentBlock) = explode("\r\n\r\n", $block, 2);
            
            \Log::info('Middleware - Headers: ' . substr($headerBlock, 0, 100));
            
            // Remove trailing CRLF from content
            $contentBlock = preg_replace("/\r\n$/", '', $contentBlock);
            
            \Log::info('Middleware - Content: ' . substr($contentBlock, 0, 50));
            
            // Parse Content-Disposition header to get field name
            if (preg_match('/name="([^"]+)"/', $headerBlock, $nameMatches)) {
                $fieldName = $nameMatches[1];
                \Log::info('Middleware - Found field: ' . $fieldName . ' = ' . $contentBlock);
                
                // Check if it's a file upload
                if (preg_match('/filename="([^"]+)"/', $headerBlock, $fileMatches)) {
                    // Skip file handling for now
                    continue;
                } else {
                    // Regular form field
                    $data[$fieldName] = $contentBlock;
                }
            }
        }
        
        \Log::info('Middleware - Final parsed data:', $data);
        
        // Merge all parsed data into the request
        if (!empty($data)) {
            $request->merge($data);
            \Log::info('Middleware - Data merged into request');
        }
    }
}