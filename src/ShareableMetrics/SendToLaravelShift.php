<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics;

use Illuminate\Support\Facades\Http;

class SendToLaravelShift
{
    public function send(array $payload): void
    {
        $httpPayload = [
            'project' => $payload['project'],
            'metrics' => $payload['metrics']->toArray()
        ];

        info(json_encode($httpPayload));

        // TODO: Replace with URL to Stats API
        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])->post('https://laravelshift.com/api/stat', $httpPayload);

        dd(
            $response->status(),
            $response->body()
        );

        if ($response->failed()) {
            dd($response->json());
        }
    }
}
