<?php

declare(strict_types=1);

namespace Service\Link\Domain\Link;

final readonly class Link implements \JsonSerializable
{
    public function __construct(
        public LinkId $id,
        public string $url,
        public string $title,
        public \DateTimeImmutable $createdAt,
        public ?\DateTimeImmutable $updatedAt,
    ) {}
    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id->id,
            'url' => $this->url,
            'title' => $this->title,
            'created_at' => $this->createdAt->format(DATE_RFC3339_EXTENDED),
            'updated_at' => $this->updatedAt ? $this->updatedAt->format(DATE_RFC3339_EXTENDED) : null,
        ];
    }
}