<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Event;
use App\Models\User;
use App\Services\QwenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Mockery;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_logs_success_event_after_successful_extract(): void
    {
        $client = Client::create([
            'username' => 'user1',
            'password' => 'pass1234',
            'name' => 'Client One',
            'keyword_count' => 10,
            'remaining_keywords' => 10,
            'is_enabled' => true,
        ]);

        $qwenMock = Mockery::mock(QwenService::class);
        $qwenMock->shouldReceive('extractInvoice')->once()->andReturn(['ok' => true]);
        $this->app->instance(QwenService::class, $qwenMock);

        $response = $this->post('/api/extract-invoice', [
            'username' => 'user1',
            'password' => 'pass1234',
            'serial_number' => 'SN-001',
            'image' => UploadedFile::fake()->create('invoice.jpg', 10, 'image/jpeg'),
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('events', [
            'client_id' => $client->id,
            'client_name' => 'Client One',
            'serial_number' => 'SN-001',
            'status' => 'success',
        ]);
    }

    public function test_events_page_renders_and_can_export_csv(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Event::create([
            'client_id' => null,
            'client_name' => 'Client A',
            'serial_number' => 'SN-A',
            'status' => 'success',
            'called_at' => now(),
        ]);

        $response = $this->get('/events');
        $response->assertStatus(200);
        $response->assertSee('Client A');
        $response->assertSee('SN-A');

        $csv = $this->get('/events?export=csv');
        $csv->assertStatus(200);
        $csv->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }
}
