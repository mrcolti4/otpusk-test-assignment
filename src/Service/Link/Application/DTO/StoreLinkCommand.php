<?php

declare(strict_types=1);

namespace Service\Link\Application\DTO;

class StoreLinkCommand
{
    public function __construct(
        public string $url,
        public string $title,
    ) {
    }
}