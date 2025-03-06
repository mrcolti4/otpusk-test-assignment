<?php

declare(strict_types=1);

namespace Infrastructure\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Types;
use Service\Common\Enums\PaginationDirection;
use Service\Common\PaginationResultData;
use Service\Link\Application\LinkDataMapper;
use Service\Link\Domain\Link\Link;
use Service\Link\Domain\Link\LinkId;
use Service\Link\Domain\Link\UpdateLink;
use Service\Link\Domain\Repository\LinkRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class LinkRepository implements LinkRepositoryInterface
{
    private const string TABLE_NAME = 'links';

    private const string ID_FIELD = 'id';
    private const string URL_FIELD = 'url';
    private const string TITLE_FIELD = 'title';
    private const string CREATED_AT_FIELD = 'created_at';
    private const string UPDATED_AT_FIELD = 'updated_at';

    public function __construct(
        private Connection $connection,
        private LinkDataMapper $linkDataMapper,
    ) {
    }

    public function nextId(): string
    {
        return Uuid::v6()->toRfc4122();
    }

    public function store(Link $link): void
    {
        $query = $this->connection->createQueryBuilder();

        $query->insert(self::TABLE_NAME)
            ->values([
                self::ID_FIELD => ':id',
                self::URL_FIELD => ':url',
                self::TITLE_FIELD => ':title',
                self::CREATED_AT_FIELD => ':created_at',
            ])
            ->setParameters([
                'id' => $link->id->id,
                'url' => $link->url,
                'title' => $link->title,
                'created_at' => $link->createdAt->format(DATE_RFC3339_EXTENDED),
            ])
            ->executeStatement();
    }

    public function getLinks(int $limit, string $cursor, PaginationDirection $direction): PaginationResultData
    {
        $query = $this->connection->createQueryBuilder();

        $operator = $direction === PaginationDirection::AFTER ? '>' : '<';

        $result = $query->select('*')
            ->from(self::TABLE_NAME, 'l')
            ->where(\sprintf('%s %s :cursor', self::ID_FIELD, $operator))
            ->setMaxResults($limit + 1)
            ->setParameter('cursor', $cursor, Types::STRING)
            ->executeQuery()
            ->fetchAllAssociative()
            ;

        $hasMore = \count($result) > $limit;
        $lastItem = \end($result);
        
        if (true === $hasMore && null !== $lastItem) {
            $nextCursor = $lastItem[self::ID_FIELD];
        }

        if($hasMore) {
            array_pop($result);
        }
        
        $links = $this->linkDataMapper->mapToLinks($result);

        return new PaginationResultData(
            hasMore: $hasMore,
            nextCursor: $nextCursor ?? '',
            data: $links
        );
    }

    public function getLinkById(LinkId $linkId): Link
    {
        $query = $this->connection->createQueryBuilder();

        $result = $query->select('*')
            ->from(self::TABLE_NAME, 'l')
            ->where('l.id = :id')
            ->setParameter('id', $linkId->id)
            ->executeQuery()
            ->fetchAssociative();

        return new Link(
            id: new LinkId($result[self::ID_FIELD]),
            url: $result[self::URL_FIELD],
            title: $result[self::TITLE_FIELD],
            createdAt: new \DateTimeImmutable($result['created_at']),
            updatedAt: $result['updated_at'] ? new \DateTimeImmutable($result['updated_at']) : null,
        );
    }

    public function removeLinkById(LinkId $linkId): void
    {
        $query = $this->connection->createQueryBuilder();

        $query->delete(self::TABLE_NAME)
            ->where('id = :id')
            ->setParameter('id', $linkId->id, Types::GUID)
            ->executeStatement();
    }

    public function updateLink(LinkId $linkId, UpdateLink $link): void
    {
        $query = $this->connection->createQueryBuilder();
        
        $query
            ->update(self::TABLE_NAME, 'l')
            ->set('url', ':url')
            ->set('title', ':title')
            ->set('updated_at', ':updated_at')
            ->where('id = :id')
            ->setParameters(
                [
                    self::URL_FIELD => $link->url,
                    self::TITLE_FIELD => $link->title,
                    self::UPDATED_AT_FIELD => $link->updatedAt,
                    self::ID_FIELD => $linkId->id
                ],
                [
                    self::URL_FIELD => Types::STRING,
                    self::TITLE_FIELD => Types::STRING,
                    self::UPDATED_AT_FIELD => Types::DATETIME_IMMUTABLE,
                ]
            )
            ->executeStatement();
    }
}