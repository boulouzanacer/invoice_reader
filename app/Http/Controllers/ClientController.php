<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $clientsQuery = Client::query();

        if ($search !== '') {
            $clientsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $clients = $clientsQuery->orderByDesc('id')->get();

        return view('clients.index', compact('clients', 'search'));
    }

    public function show(Client $client)
    {
        return response()->json($client);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:clients,username',
            'password' => 'required|string|min:6',
            'name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20|regex:/^[0-9]+$/',
            'keyword_count' => 'required|integer|min:0',
        ]);

        $validated['remaining_keywords'] = $validated['keyword_count'];
        $validated['is_enabled'] = $request->has('is_enabled');

        $client = Client::create($validated);

        Log::info('Client created: ' . ($client->name ?? $client->username) . ' by user: ' . auth()->user()->email);

        return back()->with('success', 'Client created successfully.');
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:clients,username,' . $client->id,
            'name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20|regex:/^[0-9]+$/',
            'keyword_count' => 'required|integer|min:0',
            'password' => 'nullable|string|min:6',
            // No longer validating remaining_keywords as it's read-only in the form
        ]);

        $validated['is_enabled'] = $request->has('is_enabled');

        if (($validated['password'] ?? null) === null || $validated['password'] === '') {
            unset($validated['password']);
        }

        $client->update($validated);

        Log::info('Client updated: ' . ($client->name ?? $client->username) . ' by user: ' . auth()->user()->email);

        return back()->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $name = $client->name;
        $client->delete();

        Log::info('Client deleted: ' . $name . ' by user: ' . auth()->user()->email);

        return back()->with('success', 'Client deleted successfully.');
    }

    public function toggleStatus(Client $client)
    {
        $client->update(['is_enabled' => !$client->is_enabled]);
        return back()->with('success', 'Status updated.');
    }
}
