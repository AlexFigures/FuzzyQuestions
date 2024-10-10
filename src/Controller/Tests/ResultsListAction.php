<?php

declare(strict_types=1);

namespace App\Controller\Tests;

use App\Repository\TestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ResultsListAction extends AbstractController
{
    public function __construct(private readonly TestRepository $testRepository) {}

    #[Route('/tests/results', name: 'results_list_action', methods: ['GET'])]
    public function __invoke(): Response
    {
        $tests = $this->testRepository->findAll();

        return $this->render('tests/results_list.html.twig', [
            'results' => $tests,
        ]);
    }
}
