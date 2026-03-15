<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Event;
use App\Services\QwenService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    protected $qwenService;

    public function __construct(QwenService $qwenService)
    {
        $this->qwenService = $qwenService;
    }

    /**
     * Extract invoice data - Adapted from the provided script
     */
    public function extractInvoice(Request $request)
    {
        $tempFile = null;
        $client = null;
        $serialNumber = null;
        $calledAt = now();
        try {
            // 1. Récupérer les données d'entrée (JSON ou POST)
            $input = $request->all();

            $username = $request->input('username') ?? $input['username'] ?? null;
            $password = $request->input('password') ?? $input['password'] ?? null;
            $serialNumber = $request->input('serial_number') ?? $input['serial_number'] ?? null;

            // 2. Valider les paramètres obligatoires
            if (!$username || !$password || !$serialNumber) {
                return response()->json(["error" => "Paramètres manquants. L'API requiert : image, username, password, serial_number."], 400);
            }

            // 3. Vérifier/Créer le client
            $client = Client::where('username', $username)->first();

            if (!$client) {
                Event::create([
                    'client_id' => null,
                    'client_name' => (string) $username,
                    'serial_number' => (string) $serialNumber,
                    'status' => 'error',
                    'error_message' => "Nom d'utilisateur ou mot de passe incorrect.",
                    'called_at' => $calledAt,
                ]);
                return response()->json(["error" => "Nom d'utilisateur ou mot de passe incorrect."], 401);
            }

            if ((string) $client->password !== (string) $password) {
                Event::create([
                    'client_id' => $client->id,
                    'client_name' => $client->name ?? $client->username,
                    'serial_number' => (string) $serialNumber,
                    'status' => 'error',
                    'error_message' => "Nom d'utilisateur ou mot de passe incorrect.",
                    'called_at' => $calledAt,
                ]);
                return response()->json(["error" => "Nom d'utilisateur ou mot de passe incorrect."], 401);
            }

            // 4. Vérifier l'état et le quota
            if (!$client->is_enabled) {
                Event::create([
                    'client_id' => $client->id,
                    'client_name' => $client->name ?? $client->username,
                    'serial_number' => (string) $serialNumber,
                    'status' => 'error',
                    'error_message' => 'Client désactivé.',
                    'called_at' => $calledAt,
                ]);
                return response()->json(["error" => "Client désactivé."], 403);
            }

            if ($client->remaining_keywords <= 0) {
                Event::create([
                    'client_id' => $client->id,
                    'client_name' => $client->name ?? $client->username,
                    'serial_number' => (string) $serialNumber,
                    'status' => 'error',
                    'error_message' => 'Quota insuffisant (0 restant).',
                    'called_at' => $calledAt,
                ]);
                return response()->json(["error" => "Quota insuffisant (0 restant)."], 403);
            }

            // 5. Gérer l'image (Fichier ou Base64)
            $invoicePath = null;
            if ($request->hasFile('image')) {
                $invoicePath = $request->file('image')->getRealPath();
            } else {
                $base64Data = $request->input('image') ?? $input['image'] ?? null;
                if ($base64Data) {
                    // Nettoyer le préfixe data:image/...;base64, si présent
                    if (preg_match('/^data:image\/(\w+);base64,/', $base64Data)) {
                        $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
                    }
                    
                    $decodedData = base64_decode($base64Data);
                    if ($decodedData === false) {
                        throw new Exception("Échec du décodage Base64 de l'image.");
                    }

                    $tempFile = tempnam(sys_get_temp_dir(), 'qwen_');
                    file_put_contents($tempFile, $decodedData);
                    $invoicePath = $tempFile;
                }
            }

            if (!$invoicePath || !file_exists($invoicePath)) {
                return response()->json(["error" => "Image manquante ou invalide."], 400);
            }

            // 6. Exécution de l'extraction via le service Qwen
            $extractedData = $this->qwenService->extractInvoice($invoicePath);

            // 7. Décrémenter le quota
            $client->decrement('remaining_keywords');

            // 8. Enregistrement d'événement (uniquement si succès)
            Event::create([
                'client_id' => $client->id,
                'client_name' => $client->name ?? $client->username,
                'serial_number' => (string) $serialNumber,
                'status' => 'success',
                'error_message' => null,
                'called_at' => $calledAt,
            ]);

            // 9. Réponse formatée (Identique au script source)
            return response()->json([
                'username' => $username,
                'serial_number' => $serialNumber,
                'remaining_quota' => $client->remaining_keywords,
                'invoice_data' => $extractedData
            ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        } catch (Exception $e) {
            Log::error("Erreur d'extraction API : " . $e->getMessage());
            if ($client && $serialNumber) {
                $errorMessage = substr((string) $e->getMessage(), 0, 500);
                Event::create([
                    'client_id' => $client->id,
                    'client_name' => $client->name ?? $client->username,
                    'serial_number' => (string) $serialNumber,
                    'status' => 'error',
                    'error_message' => $errorMessage,
                    'called_at' => $calledAt,
                ]);
            }
            return response()->json(["error" => $e->getMessage()], 500);
        } finally {
            // Nettoyage du fichier temporaire
            if ($tempFile && file_exists($tempFile)) {
                unlink($tempFile);
            }
        }
    }

    public function getClients()
    {
        return response()->json(Client::all());
    }

    public function getClient(Client $client)
    {
        return response()->json($client);
    }

    public function updateKeywords(Request $request, Client $client)
    {
        $request->validate([
            'keywords_used' => 'required|integer|min:1',
        ]);

        if (!$client->is_enabled) {
            return response()->json(['error' => 'Client is disabled'], 403);
        }

        if ($client->remaining_keywords < $request->keywords_used) {
            return response()->json(['error' => 'Insufficient keywords'], 400);
        }

        $client->decrement('remaining_keywords', $request->keywords_used);

        return response()->json([
            'message' => 'Keywords updated',
            'remaining_keywords' => $client->remaining_keywords
        ]);
    }
}
