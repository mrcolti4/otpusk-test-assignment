<?php

declare(strict_types=1);

namespace Service\Common;

final class PaginationResultData implements \JsonSerializable
{
    public function __construct(
        public bool $hasMore,
        public ?string $nextCursor,
        public array $data,
    ) {}

    public function jsonSerialize(): mixed
    {
        return [
            'hasMore' => $this->hasMore,
            'nextCursor' => $this->nextCursor,
            'data' => $this->data
        ];
    }
}