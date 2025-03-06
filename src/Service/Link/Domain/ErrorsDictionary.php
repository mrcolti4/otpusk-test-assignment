<?php

declare(strict_types=1);

namespace Service\Link\Domain;

enum ErrorsDictionary: string
{
    case INVALID_LINK_ID = 'link.invalid.id';
}