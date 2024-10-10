<?php

declare(strict_types=1);

namespace App\Controller\Tests;

use App\Repository\TestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ResultsAction extends AbstractController
{
    public function __construct(private readonly TestRepository $testRepository) {}

    #[Route('/tests/results/{id}', name: 'results_action', methods: ['GET'])]
    public function __invoke(string $id): Response
    {
        $test = $this->testRepository->find($id);
        if (\is_null($test)) {
            throw $this->createNotFoundException('Test not found');
        }

        return $this->render('tests/results.html.twig', [
            'results' => $test,
        ]);
    }
}
