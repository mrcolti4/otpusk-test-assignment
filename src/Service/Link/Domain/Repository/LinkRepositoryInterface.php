<?php

declare(strict_types=1);

namespace Service\Link\Domain\Repository;

use Service\Link\Domain\Link\Link;
use Service\Link\Domain\Link\LinkId;

interface LinkRepositoryInterface
{
    public function store(Link $link): void;

    public function getLinks(Link $link): array;

    public function getLinkById(LinkId $linkId): Link;

    public function removeLinkById(LinkId $linkId): void;

    public function updateLink(LinkId $linkId): void;
} 