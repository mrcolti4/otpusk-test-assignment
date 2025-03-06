<?php

declare(strict_types=1);

namespace Service\Link\Application;

use Service\Link\Domain\Link\Link;
use Service\Link\Domain\Link\LinkId;

class LinkDataMapper
{
    public function mapToLinks(array $links): array
    {
        $mappedLinks = [];
        
        foreach($links as $link) {
            $mappedLinks[] = new Link(
                new LinkId($link['id']),
                $link['url'],
                $link['title'],
                new \DateTimeImmutable($link['createdAt']),
                new \DateTimeImmutable($link['updatedAt']),
            );
        }

        return $mappedLinks;
    }
}