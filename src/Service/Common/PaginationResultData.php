<?php

declare(strict_types=1);

namespace Service\Common;

final class PaginationResultData
{
    public function __construct(
        public bool $hasMore,
        public ?string $nextCursor,
        public array $data,
    ) {}
}