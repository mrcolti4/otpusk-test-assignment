<?php

declare(strict_types=1);

namespace Infrastructure\Controller;

use Service\Link\Application\DTO\GetLinksQuery;
use Service\Link\Application\LinkHandlerInterface;
use Service\Link\Domain\Link\LinkId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin/links', name: 'admin.view.links.')]
class LinkViewController extends AbstractController
{
    public function __construct(
        private LinkHandlerInterface $linkHandler
    ) {}
    #[Route(path: '/', name: 'index', methods: ['GET'])]
    public function index()
    {
        $query = new GetLinksQuery(
            limit: 2,
            cursor: '',
            direction: 'after',
        );

        return $this->render('links/index.html.twig', [
            'items' => $this->linkHandler->getLinks($query),
        ]);
    }

    #[Route(path: '/edit/{linkId}', name: 'edit', methods: ['GET'])]
    public function edit(string $linkId)
    {
        return $this->render('links/edit.html.twig', [
            'link' => $this->linkHandler->getLinkById(new LinkId($linkId)),
        ]);
    }

    #[Route(path: '/store', name: 'store', methods: ['GET'])]
    public function store()
    {
        return $this->render('links/store.html.twig');
    }

    #[Route(path: '/{linkId}/delete', name: 'delete', methods: ['GET'])]
    public function delete(string $linkId)
    {
        $this->linkHandler->removeLink(new LinkId($linkId));

        $query = new GetLinksQuery(
            limit: 2,
            cursor: '',
            direction: 'after',
        );

        return $this->render('links/index.html.twig', [
            'items' => $this->linkHandler->getLinks($query),
        ]);
    }
}