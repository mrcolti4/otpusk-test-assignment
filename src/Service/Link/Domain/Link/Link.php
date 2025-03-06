<?php

declare(strict_types=1);

namespace Service\Link\Domain\Link;

use Service\Link\Domain\Link\LinkId;

final readonly class Link implements \JsonSerializable
{
    public function __construct(
        private LinkId $id,
        private string $url,
        private string $title,
    ) {}
    public function jsonSerialize(): mixed
    {
        return [];
    }
}