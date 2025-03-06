<?php

declare(strict_types=1);

namespace Service\Link\Application\DTO;

class GetLinksQuery
{
    public function __construct(
        public int $limit,
        public string $cursor,
        public string $direction,
    ) {
    }
}