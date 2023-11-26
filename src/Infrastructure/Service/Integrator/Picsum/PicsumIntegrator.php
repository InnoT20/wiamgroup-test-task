<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Integrator\Picsum;

use App\Infrastructure\Service\Integrator\Picsum\Exception\ImageNotFoundException;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\StreamInterface;

class PicsumIntegrator
{
    private const INFO_PATH = '/id/%d/info';
    private const IMAGE_PATH = '/id/%d/%d/%d';
    private const NOT_FOUND = 404;

    private readonly PicsumGateway $gateway;

    public function __construct(string $domain)
    {
        $this->gateway = new PicsumGateway($domain);
    }

    public function getImage(int $id, int $width = 640, int $height = 320): StreamInterface
    {
        $path = sprintf(self::IMAGE_PATH, $id, $width, $height);

        try {
            $response = $this->gateway->get($path);
        } catch (ClientException $exception) {
            if ($exception->getCode() === self::NOT_FOUND) {
                throw new ImageNotFoundException('Image not found');
            }

            throw $exception;
        }

        return $response->getBody();
    }

    public function info(int $id): array
    {
        $path = sprintf(self::INFO_PATH, $id);

        try {
            $response = $this->gateway->get($path);
        } catch (ClientException $exception) {
            if ($exception->getCode() === self::NOT_FOUND) {
                throw new ImageNotFoundException('Image not found');
            }

            throw $exception;
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}