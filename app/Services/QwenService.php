<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use finfo;

class QwenService
{
    protected $apiKey;
    protected $baseUrl;
    protected $model;

    const INVOICE_PROMPT = <<<EOD
Extract all invoice data and return JSON only.
If a value is missing use null.
Amounts must be numeric.
codebarre doesn't contain description or designation or product name.
line_tax focus on tva, tax each item.
line_remise focus on remise each item.
remise_total focus on remise total.
Dates must be ISO format if possible (YYYY-MM-DD).
Structure:

{
  "invoice_number": string|null,
  "invoice_date": string|null,
  "due_date": string|null,
  "seller_name": string|null,
  "buyer_name": string|null,
  "buyer_phone": string|null,
  "currency": string|null,
  "subtotal": number|null,
  "tax_total": number|null,
  "remise_total": number|null
  "total": number|null,
  "line_items": [
    {
      "code": string|null,
      "codebarre": string|null,
      "description": string|null, 
      "quantity": number|null,
      "unit_price": number|null,
      "line_tax": number|null,
      "line_remise": number|null,  
      "line_total": number|null
    }
  ]
}
EOD;

    public function __construct()
    {
        $this->apiKey = config('services.dashscope.key');
        $this->baseUrl = config('services.dashscope.base_url');
        $this->model = config('services.dashscope.model');
    }

    /**
     * Convert an image path to a Data URL Base64 using finfo
     *
     * @param string $imagePath
     * @return string
     * @throws Exception
     */
    public function imageToBase64DataUrl($imagePath)
    {
        if (!file_exists($imagePath)) {
            throw new Exception("Le fichier image n'existe pas : " . $imagePath);
        }

        $imageData = file_get_contents($imagePath);
        $base64 = base64_encode($imageData);
        
        // Use finfo as in the script
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($imagePath);
        
        return "data:{$mimeType};base64,{$base64}";
    }

    /**
     * Extract invoice data using Qwen API
     *
     * @param string $imagePath
     * @return array
     * @throws Exception
     */
    public function extractInvoice($imagePath)
    {
        $chatUrl = rtrim($this->baseUrl, '/') . '/chat/completions';

        $payload = [
            'model' => $this->model,
            'messages' => [
                ['role' => 'system', 'content' => 'You extract structured invoice data.'],
                [
                    'role' => 'user',
                    'content' => [
                        [
                            'type' => 'image_url',
                            'image_url' => [
                                'url' => $this->imageToBase64DataUrl($imagePath)
                            ]
                        ],
                        [
                            'type' => 'text',
                            'text' => self::INVOICE_PROMPT
                        ]
                    ]
                ]
            ],
            'response_format' => ['type' => 'json_object'],
            'temperature' => 0
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json'
        ])->timeout(120)->post($chatUrl, $payload);

        if ($response->failed()) {
            $httpCode = $response->status();
            $errorBody = $response->body();
            Log::error("Erreur API {$httpCode} : " . $errorBody);
            throw new Exception("Erreur API {$httpCode} : " . ($errorBody ?: 'Unknown error'));
        }

        $result = $response->json();
        $content = $result['choices'][0]['message']['content'];

        return json_decode($content, true);
    }
}
