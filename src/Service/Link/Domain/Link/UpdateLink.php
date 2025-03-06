<?php

declare(strict_types=1);

namespace Service\Link\Domain\Link;

final readonly class UpdateLink implements \JsonSerializable
{
    public function __construct(
        public string $url,
        public string $title,
        public \DateTimeImmutable $updatedAt,
    ) {}
    public function jsonSerialize(): mixed
    {
        return [
            'url' => $this->url,
            'title' => $this->title,
            'updated_at' => $this->updatedAt,
        ];    
    }
}