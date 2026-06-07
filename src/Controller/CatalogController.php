<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class CatalogController extends AbstractController
{
    public function catalog(): Response
    {
        return $this->render('@UxBlocksLive/catalog.html.twig');
    }
}
