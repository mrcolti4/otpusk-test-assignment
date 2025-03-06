<?php

declare(strict_types=1);

namespace Service\Link\Application;

use Service\Common\Enums\PaginationDirection;
use Service\Link\Application\DTO\GetLinksQuery;
use Service\Common\PaginationResultData;
use Service\Link\Application\DTO\StoreLinkCommand;
use Service\Link\Application\DTO\UpdateLinkCommand;
use Service\Link\Domain\Link\LinkId;
use Service\Link\Domain\Link\Link;
use Service\Link\Domain\Link\UpdateLink;
use Service\Link\Domain\Repository\LinkRepositoryInterface;

class LinkHandler implements LinkHandlerInterface
{
    public function __construct(
        private LinkRepositoryInterface $linkRepository,
    ) {}
    public function getLinks(GetLinksQuery $query): PaginationResultData
    {
        return $this->linkRepository->getLinks(
            limit: $query->limit,
            cursor: $query->cursor,
            direction: PaginationDirection::from($query->direction),
        );
    }

    public function getLinkById(LinkId $linkId): Link
    {
        return $this->linkRepository->getLinkById($linkId);
    }

    public function createLink(StoreLinkCommand $command): void
    {
        $link = new Link(
            new LinkId($this->linkRepository->nextId()),
            $command->url,
            $command->title,
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
        );
        $this->linkRepository->store($link);
    }

    public function updateLink(UpdateLinkCommand $command): void
    {
        $link = new UpdateLink(
            $command->url,
            $command->title,
            new \DateTimeImmutable(),
        );
        $this->linkRepository->updateLink(
            new LinkId($command->id),
            $link
        );
    }

    public function removeLink(LinkId $linkId): void
    {
        $this->linkRepository->removeLinkById($linkId);
    }
}