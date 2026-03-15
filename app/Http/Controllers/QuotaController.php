<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Quota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuotaController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $date = trim((string) $request->query('date', ''));

        $quotasQuery = Quota::query()->with('client');

        if ($search !== '') {
            $quotasQuery->whereHas('client', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        if ($date !== '') {
            $quotasQuery->whereDate('quota_date', $date);
        }

        $quotas = $quotasQuery->orderByDesc('id')->paginate(50)->withQueryString();

        $clients = Client::orderBy('name')->orderBy('username')->get();

        return view('quotas.index', [
            'quotas' => $quotas,
            'clients' => $clients,
            'search' => $search,
            'date' => $date,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|integer|min:1',
        ]);

        $quotaDate = now()->toDateString();

        DB::transaction(function () use ($validated, $quotaDate) {
            $client = Client::lockForUpdate()->findOrFail($validated['client_id']);

            $used = max(0, (int) $client->keyword_count - (int) $client->remaining_keywords);
            $newTotal = (int) $client->keyword_count + (int) $validated['amount'];
            $newRemaining = max(0, $newTotal - $used);

            Quota::create([
                'client_id' => $client->id,
                'amount' => (int) $validated['amount'],
                'quota_date' => $quotaDate,
            ]);

            $client->update([
                'keyword_count' => $newTotal,
                'remaining_keywords' => $newRemaining,
            ]);
        });

        Log::info('Quota added by user: ' . auth()->user()->email);

        return back()->with('success', 'Quota ajouté avec succès.');
    }

    public function update(Request $request, Quota $quota)
    {
        $validated = $request->validate([
            'amount' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($quota, $validated) {
            $quota->refresh();
            $client = Client::lockForUpdate()->findOrFail($quota->client_id);

            $oldAmount = (int) $quota->amount;
            $newAmount = (int) $validated['amount'];
            $diff = $newAmount - $oldAmount;

            $used = max(0, (int) $client->keyword_count - (int) $client->remaining_keywords);
            $newTotal = max(0, (int) $client->keyword_count + $diff);
            $newRemaining = max(0, $newTotal - $used);

            $quota->update([
                'amount' => $newAmount,
            ]);

            $client->update([
                'keyword_count' => $newTotal,
                'remaining_keywords' => $newRemaining,
            ]);
        });

        Log::info('Quota updated by user: ' . auth()->user()->email);

        return back()->with('success', 'Quota modifié avec succès.');
    }

    public function destroy(Quota $quota)
    {
        DB::transaction(function () use ($quota) {
            $quota->refresh();
            $client = Client::lockForUpdate()->findOrFail($quota->client_id);

            $used = max(0, (int) $client->keyword_count - (int) $client->remaining_keywords);
            $newTotal = max(0, (int) $client->keyword_count - (int) $quota->amount);
            $newRemaining = max(0, $newTotal - $used);

            $quota->delete();

            $client->update([
                'keyword_count' => $newTotal,
                'remaining_keywords' => $newRemaining,
            ]);
        });

        Log::info('Quota deleted by user: ' . auth()->user()->email);

        return back()->with('success', 'Quota supprimé avec succès.');
    }
}

