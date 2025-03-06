<?php

declare(strict_types=1);

namespace Service\Link\Application;

use Service\Link\Application\DTO\GetLinksQuery;
use Service\Common\PaginationResultData;
use Service\Link\Application\DTO\StoreLinkCommand;
use Service\Link\Application\DTO\UpdateLinkCommand;
use Service\Link\Domain\Link\LinkId;
use Service\Link\Domain\Link\Link;

class LinkHandler implements LinkHandlerInterface
{
    public function getLinks(GetLinksQuery $query): PaginationResultData
    {
        
    }

    public function getLinkById(LinkId $linkId): Link
    {
        
    }

    public function createLink(StoreLinkCommand $command): void
    {
        
    }

    public function updateLink(UpdateLinkCommand $command): void
    {
        
    }

    public function removeLink(LinkId $linkId): void
    {
        
    }
}