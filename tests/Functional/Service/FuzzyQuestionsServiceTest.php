<?php

namespace App\Tests\Functional\Service;

use App\Entity\Answer;
use App\Entity\Question;
use App\Repository\QuestionRepository;
use App\Service\FuzzyQuestionsServiceInterface;
use App\Tests\Fixtures\QuestionsFixtures;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class FuzzyQuestionsServiceTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private FuzzyQuestionsServiceInterface $service;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();
        $entityManager = $container->get(EntityManagerInterface::class);
        assert($entityManager instanceof EntityManagerInterface);
        $this->entityManager = $entityManager;
        $service = $container->get(FuzzyQuestionsServiceInterface::class);
        assert($service instanceof FuzzyQuestionsServiceInterface);
        $this->service = $service;
    }

    /**
     * @return array<string, array<int, \App\Entity\Question|null>>
     */
    public static function questionDataProvider(): array
    {
        $container = self::getContainer();
        $entityManager = $container->get(EntityManagerInterface::class);
        assert($entityManager instanceof EntityManagerInterface);
        $purger = new ORMPurger($entityManager);
        $purger->purge();
        $fixtures = new QuestionsFixtures();
        $fixtures->load($entityManager);
        $questionRepository = $entityManager->getRepository(Question::class);
        assert($questionRepository instanceof QuestionRepository);

        return [
            'onePlusOne'     => [$questionRepository->findOneBy(['text' => '1 + 1 ='])],
            'twoPlusTwo'     => [$questionRepository->findOneBy(['text' => '2 + 2 ='])],
            'threePlusThree' => [$questionRepository->findOneBy(['text' => '3 + 3 ='])],
            'fourPlusFour'   => [$questionRepository->findOneBy(['text' => '4 + 4 ='])],
            'fivePlusFive'   => [$questionRepository->findOneBy(['text' => '5 + 5 ='])],
            'sixPlusSix'     => [$questionRepository->findOneBy(['text' => '6 + 6 ='])],
            'sevenPlusSeven' => [$questionRepository->findOneBy(['text' => '7 + 7 ='])],
            'eightPlusEight' => [$questionRepository->findOneBy(['text' => '8 + 8 ='])],
            'ninePlusNine'   => [$questionRepository->findOneBy(['text' => '9 + 9 ='])],
            'tenPlusTen'     => [$questionRepository->findOneBy(['text' => '10 + 10 ='])],
        ];
    }

    /**
     * @dataProvider questionDataProvider
     *
     * @param Question $question
     */
    public function testCheckAnswers(Question $question): void
    {
        $answers = $this->entityManager->getRepository(Answer::class)->findBy(['question' => $question]);
        $combinations = $this->generateCombinations($answers);
        $classified = $this->classifyCombinations($combinations);
        foreach ($classified['true'] as $combination) {
            $question->getAnswers()->clear();
            $trueQuestion = (clone $question)
            ->setText((string) $question->getText())
            ->setFuzzy((bool) $question->isFuzzy());
            foreach ($combination as $answer) {
                $trueQuestion->addAnswer($answer);
            }
            $result = $this->service->checkAnswers($trueQuestion);
            self::assertTrue($result->isCorrect());
        }
        foreach ($classified['false'] as $combination) {
            $question->getAnswers()->clear();
            $falsyQuestion = (clone $question)
            ->setText((string) $question->getText())
            ->setFuzzy((bool) $question->isFuzzy());
            foreach ($combination as $answer) {
                $falsyQuestion->addAnswer($answer);
            }
            $result = $this->service->checkAnswers($falsyQuestion);
            self::assertFalse($result->isCorrect());
        }
    }

    /**
     * @return void
     */
    public function testNoAnswersFoundForQuestion(): void
    {
        $question = new Question();
        $question->setText('No answers found');
        $question->setFuzzy(false);
        $this->entityManager->persist($question);
        $this->entityManager->flush();
        $this->expectExceptionMessage('No answers found');
        $this->service->checkAnswers($question);
    }

    /**
     * Method to generate all possible combinations of answers.
     *
     * @param array<Answer> $answers
     *
     * @return array<array-key, array<array-key, Answer>>
     */
    private function generateCombinations(array $answers): array
    {
        $result = [];
        $total = count($answers);
        $combinations = 1 << $total;

        for ($i = 1; $i < $combinations; ++$i) {
            $combination = [];
            for ($j = 0; $j < $total; ++$j) {
                if ($i & (1 << $j)) {
                    $combination[] = $answers[$j];
                }
            }
            $result[] = $combination;
        }

        return $result;
    }

    /**
     * Method to classify combinations into true and false.
     *
     * @param array<array-key, array<array-key, Answer>> $combinations
     *
     * @return array<string, array<array-key, array<array-key, Answer>>>
     */
    private function classifyCombinations(array $combinations): array
    {
        $classified = [
            'true'  => [],
            'false' => [],
        ];

        foreach ($combinations as $combination) {
            $isValid = true;
            foreach ($combination as $answer) {
                if (!$answer->isCorrect() && !$answer->isFuzzyCorrect()) {
                    $isValid = false;

                    break;
                }
            }
            if ($isValid) {
                $classified['true'][] = $combination;
            } else {
                $classified['false'][] = $combination;
            }
        }

        return $classified;
    }
}
