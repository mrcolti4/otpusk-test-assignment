<?php

declare(strict_types=1);

namespace Service\Link\Domain\Entity;

use Doctrine\ORM\Mapping\Column;

class Link
{
    public function __construct(
        #[Column(name: 'id', type: 'string', unique: true)]
        public string $id,
        #[Column(name: 'url', type: 'string')]
        public string $url,
        #[Column(name: 'title', type: 'string', unique: true)]
        public string $title,
        #[Column(name: 'created_at', type: 'datetime_immutable', nullable: false)]
        public string $createdAt,
        #[Column(name: 'updated_at', type: 'datetime_immutable', nullable: true)]
        public string $updatedAt,
    ) {}
}