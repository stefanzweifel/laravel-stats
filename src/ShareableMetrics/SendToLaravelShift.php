<?php

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
        $response = Http::post('https://laravelshift.com/api/stat', $httpPayload);

        dd(
            $response->status(),
            $response->json(),
            $response->body()
        );

        if ($response->failed()) {
            dd($response->json());
        }
    }

}
