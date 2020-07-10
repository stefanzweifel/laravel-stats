<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class SendToLaravelShift
{
    public function send(array $payload): Response
    {
        info('Send laravel-stats data to Laravel Shift', $payload);

        return Http::withHeaders([
            'Accept' => 'application/json'
        ])->post('https://laravelshift.com/api/stat', $payload);
    }
}
