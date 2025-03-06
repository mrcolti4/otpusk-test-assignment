<?php

declare(strict_types=1);

namespace Infrastructure\Controller;

use Infrastructure\Requests\CreateLinkRequest;
use Infrastructure\Requests\GetLinksRequest;
use Service\Common\Enums\PaginationDirection;
use Service\Link\Application\DTO\GetLinksQuery;
use Service\Link\Application\DTO\StoreLinkCommand;
use Service\Link\Application\LinkHandlerInterface;
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
    #[Route(path: '/', name: 'index', methods: ['GET'])]
    public function index(
        #[MapRequestPayload]
        GetLinksRequest $request,
    ): JsonResponse
    {
        $query = new GetLinksQuery(
            limit: $request->limit,
            cursor: $request->cursor,
            direction: PaginationDirection::from($request->direction)->value,
        );

        $data = $this->linkHandler->getLinks($query);

        return new JsonResponse(['success' => true, 'data' => $data->jsonSerialize()], 200);
    }

    #[Route(path: '/{link}', name: 'getOne', methods: ['GET'])]
    public function getById(): JsonResponse
    {

        return new JsonResponse();
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
    #[Route(path: '/{link}', name: 'update', methods: ['PUT', 'PATCH'])]
    public function update(): JsonResponse
    {

        return new JsonResponse();
    }

    #[Route(path: '/{link}', name: 'delete', methods: ['DELETE'])]
    public function delete(): JsonResponse
    {

        return new JsonResponse();
    }
}