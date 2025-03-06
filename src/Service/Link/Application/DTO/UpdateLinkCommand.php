<?php

declare(strict_types=1);

namespace Service\Link\Application\DTO;

class UpdateLinkCommand
{
    public function __construct(
        public string $id,
        public string $url,
        public string $title,
    ) {
    }
}