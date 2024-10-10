<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ContactAction extends AbstractController
{
    #[Route(path: '/contact', name: 'contact')]
    public function index(): Response
    {
        return $this->render('contact.html.twig');
    }
}
