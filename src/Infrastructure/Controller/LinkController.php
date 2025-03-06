<?php

declare(strict_types=1);

namespace Infrastructure\Controller;

use Infrastructure\Requests\CreateLinkRequest;
use Infrastructure\Requests\GetLinksRequest;
use Infrastructure\Requests\UpdateLinkRequest;
use Service\Link\Application\DTO\GetLinksQuery;
use Service\Link\Application\DTO\StoreLinkCommand;
use Service\Link\Application\DTO\UpdateLinkCommand;
use Service\Link\Application\LinkHandlerInterface;
use Service\Link\Domain\Link\LinkId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Route(path: '/api/admin/links', name: 'admin.links.')]
class LinkController extends AbstractController
{
    public function __construct(
        private LinkHandlerInterface $linkHandler,
    ) {}
    #[Route(path: '/', name: 'index', methods: ['POST'])]
    public function index(
        #[MapRequestPayload]
        GetLinksRequest $request,
    ): JsonResponse
    {
        $query = new GetLinksQuery(
            limit: $request->limit,
            cursor: $request->cursor,
            direction: $request->direction,
        );

        $data = $this->linkHandler->getLinks($query);

        return new JsonResponse(['success' => true, 'data' => $data->jsonSerialize()], 200);
    }

    #[Route(path: '/{linkId}', name: 'getOne', methods: ['GET'])]
    public function getById(
        string $linkId
    ): JsonResponse
    {
        $link = $this->linkHandler->getLinkById(new LinkId($linkId));

        return new JsonResponse(['success' => true, 'data' => $link->jsonSerialize()], 200);
    }

    #[Route(path: '/create', name: 'create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload]
        CreateLinkRequest $request
    ): JsonResponse
    {
        $command = new StoreLinkCommand(
            url: $request->url,
            title: $request->title,
        );

        $this->linkHandler->createLink($command);

        return new JsonResponse(['success' => true], 200);
    }
    #[Route(path: '/{linkId}', name: 'update', methods: ['PUT', 'PATCH'])]
    public function update(
        string $linkId,
        #[MapRequestPayload]
        UpdateLinkRequest $request,
    ): JsonResponse
    {
        $command = new UpdateLinkCommand(
            id: $linkId,
            url: $request->url,
            title: $request->title
        );
        $this->linkHandler->updateLink($command);

        return new JsonResponse(['success' => true]);
    }

    #[Route(path: '/{linkId}', name: 'delete', methods: ['DELETE'])]
    public function delete(
        string $linkId,
    ): JsonResponse
    {
        $this->linkHandler->removeLink(new LinkId($linkId));

        return new JsonResponse(['success' => true]);
    }
}