<?php

declare(strict_types=1);

namespace Service\Link\Domain\Link;

use Service\Link\Domain\ErrorsDictionary;

final class LinkId
{
    private const string REGEX = '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/';
    public function __construct(
        public string $id
    )
    {
        if (1 !== preg_match(self::REGEX, $this->id)) {
            throw new \InvalidArgumentException(ErrorsDictionary::INVALID_LINK_ID->value);
        }
    }

    public function __toString(): string
    {
        return $this->id;
    }
}