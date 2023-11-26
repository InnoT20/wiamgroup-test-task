<?php
declare(strict_types=1);

namespace App\Infrastructure\Service\Integrator\Picsum;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class PicsumGateway
{
    private const MAX_RETRY = 3;

    private readonly Client $client;

    public function __construct(string $domain)
    {
        $this->client = new Client([
            'base_uri' => $domain,
            'timeout' => 5.0,
        ]);
    }

    public function get(string $path): ResponseInterface
    {
        $retries = 0;

        // simple retry logic
        while ($retries < self::MAX_RETRY) {
            try {
                return $this->client->get($path);
            } catch (GuzzleException $e) {
                if ($e->getCode() === 404) {
                    break;
                }
                if ($retries < self::MAX_RETRY) {
                    // todo: log retry
                    continue;
                }
            } finally {
                $retries++;
            }
        }

        throw $e;  // todo: wrapper for integrator exception
    }
}