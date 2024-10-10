<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomepageAction extends AbstractController
{
    #[Route(path: '/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('homepage.html.twig');
    }
}
