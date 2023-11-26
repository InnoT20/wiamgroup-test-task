<?php

use App\Infrastructure\Service\RandomImage\Dimension;

return [
    'dimension' => new Dimension(
        width: $_ENV['PICSUM_IMAGE_WIDTH'] ?? 600,
        height: $_ENV['PICSUM_IMAGE_HEIGHT'] ?? 500,
    ),
];
