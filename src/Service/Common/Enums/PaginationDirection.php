<?php

declare(strict_types=1);

namespace Service\Common\Enums;

enum PaginationDirection: string
{
    case AFTER = 'after';
    case BEFORE = 'before';
}