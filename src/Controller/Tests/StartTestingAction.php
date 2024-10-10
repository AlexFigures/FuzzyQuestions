<?php

declare(strict_types=1);

namespace App\Controller\Tests;

use App\Entity\Test;
use App\Form\QuestionsCollectionType;
use App\Repository\QuestionRepository;
use App\Service\FuzzyQuestionsServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StartTestingAction extends AbstractController
{
    public function __construct(
        private readonly QuestionRepository $questionRepository,
        private readonly FuzzyQuestionsServiceInterface $fuzzyQuestionsService,
        private readonly EntityManagerInterface $entityManager
    ) {}

    #[Route(path: '/tests/start', name: 'start_testing_action', methods: ['GET', 'POST'])]
    public function __invoke(Request $request): Response
    {
        $questions = $this->questionRepository->findAll(); // TODO add pagination?
        $form = $this->createForm(QuestionsCollectionType::class, ['questions' => $questions]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            assert(is_array($data));
            $questions = $data['questions'] ?? throw new InvalidArgumentException('Questions not found');
            $this->entityManager->clear();
            $test = new Test();
            foreach ($questions as $question) {
                $test->addTestResult($this->fuzzyQuestionsService->checkAnswers($question));
            }
            $this->entityManager->persist($test);
            $this->entityManager->flush();

            return $this->redirectToRoute('results_action', ['id' => $test->getId()]);
        }

        return $this->render('tests/questions.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
