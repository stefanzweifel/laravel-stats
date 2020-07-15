<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SendToLaravelShift
{
    public function send(array $payload): void
    {
        info('Sharing stats with stats.laravelshift.com', $payload);

        try {
            $client = new Client([
                'base_uri' => 'https://laravelshift.com',
                'timeout' => 1,
                'headers' => ['Accept' => 'application/json'],
            ]);

            $response = $client->request('POST', '/api/stat', [
                'json' => $payload,
            ]);
        } catch (GuzzleException $exception) {
            error('unable to share stats: ' . $exception->getMessage());
        }

        if (in_array($response->getStatusCode(), [201, 204])) {
            info("Thanks for sharing your project data with the community!");
        }
    }
}
