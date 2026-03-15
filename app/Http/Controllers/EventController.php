<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $serial = trim((string) $request->query('serial', ''));
        $sort = strtolower((string) $request->query('sort', 'desc'));
        $export = (string) $request->query('export', '');

        $direction = $sort === 'asc' ? 'asc' : 'desc';

        $eventsQuery = Event::query()->with('client');

        if ($search !== '') {
            $eventsQuery->where(function ($q) use ($search) {
                $q->where('client_name', 'like', '%' . $search . '%')
                    ->orWhereHas('client', function ($qc) use ($search) {
                        $qc->where('name', 'like', '%' . $search . '%')
                            ->orWhere('username', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($serial !== '') {
            $eventsQuery->where('serial_number', 'like', '%' . $serial . '%');
        }

        $eventsQuery->orderBy('called_at', $direction)->orderByDesc('id');

        if ($export === 'csv') {
            return $this->exportCsv($eventsQuery->get(), $direction, $search, $serial);
        }

        $events = $eventsQuery->paginate(20)->withQueryString();

        return view('events.index', [
            'events' => $events,
            'search' => $search,
            'serial' => $serial,
            'sort' => $direction,
        ]);
    }

    private function exportCsv($events, string $direction, string $search, string $serial): StreamedResponse
    {
        $filename = 'events_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($events) {
            $out = fopen('php://output', 'w');

            fputcsv($out, ['client_name', 'serial_number', 'called_at', 'status', 'error_message']);

            foreach ($events as $event) {
                fputcsv($out, [
                    $event->client_name,
                    $event->serial_number,
                    $event->called_at?->format('d/m/Y H:i:s'),
                    $event->status,
                    $event->error_message,
                ]);
            }

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
