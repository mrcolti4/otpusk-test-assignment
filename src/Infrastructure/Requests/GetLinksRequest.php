<?php

declare(strict_types=1);

namespace Infrastructure\Requests;

class GetLinksRequest
{
    public function __construct(
        public int $limit,
        public string $cursor,
        public string $direction,
    ) {
    }
}