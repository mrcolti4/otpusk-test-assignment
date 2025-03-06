<?php

declare(strict_types=1);

namespace Service\Link\Domain\Link;

use Service\Link\Domain\Link\LinkId;

final readonly class Link implements \JsonSerializable
{
    public function __construct(
        public LinkId $id,
        public string $url,
        public string $title,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {}
    public function jsonSerialize(): mixed
    {
        return [];
    }
}