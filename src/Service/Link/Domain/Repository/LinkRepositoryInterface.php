<?php

declare(strict_types=1);

namespace Service\Link\Domain\Repository;

use Service\Common\Enums\PaginationDirection;
use Service\Common\PaginationResultData;
use Service\Link\Domain\Link\Link;
use Service\Link\Domain\Link\LinkId;
use Service\Link\Domain\Link\UpdateLink;

interface LinkRepositoryInterface
{
    public function nextId(): string;

    public function store(Link $link): void;

    public function getLinks(int $limit, string $cursor, PaginationDirection $direction): PaginationResultData;

    public function getLinkById(LinkId $linkId): Link;

    public function removeLinkById(LinkId $linkId): void;

    public function updateLink(LinkId $linkId, UpdateLink $link): void;
} 