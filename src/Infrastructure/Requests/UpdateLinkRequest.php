<?php

declare(strict_types=1);

namespace Infrastructure\Requests;

class UpdateLinkRequest
{
    public function __construct(
        public string $url = '',
        public string $title = '',
    ) {
    }
}