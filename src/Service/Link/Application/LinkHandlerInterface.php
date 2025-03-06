<?php

declare(strict_types=1);

namespace Service\Link\Application;

use Service\Common\PaginationResultData;
use Service\Link\Application\DTO\GetLinksQuery;
use Service\Link\Application\DTO\StoreLinkCommand;
use Service\Link\Application\DTO\UpdateLinkCommand;
use Service\Link\Domain\Link\Link;
use Service\Link\Domain\Link\LinkId;

interface LinkHandlerInterface
{
    public function getLinks(GetLinksQuery $query): PaginationResultData;

    public function getLinkById(LinkId $linkId): Link;

    public function createLink(StoreLinkCommand $command): void;

    public function updateLink(UpdateLinkCommand $command): void;

    public function removeLink(LinkId $linkId): void;
}