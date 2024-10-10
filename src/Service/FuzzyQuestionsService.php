<?php

namespace App\Service;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\TestResult;
use App\Repository\AnswerRepository;
use Exception;
use Psr\Log\LoggerInterface;

final readonly class FuzzyQuestionsService implements FuzzyQuestionsServiceInterface
{
    public function __construct(
        private AnswerRepository $answerRepository,
        private LoggerInterface $logger
    ) {}

    public function checkAnswers(Question $question): TestResult
    {
        try {
            $answers = $this->answerRepository->findBy(['question' => $question->getId()]);
            if ($answers === []) {
                throw new Exception('No answers found');
            }
        } catch (Exception $e) {
            $this->logger->error('Error fetching answers', ['exception' => $e]);

            throw $e;
        }

        $correctAnswers = $this->getCorrectAnswers($answers);
        $fuzzyCorrectAnswers = $this->getFuzzyCorrectAnswers($answers);

        $userAnswers = $question->getAnswers()->toArray();
        $userAnswerIds = array_map(static fn (Answer $answer): string => (string) $answer->getId()?->toRfc4122(), $userAnswers);

        $testResult = new TestResult();
        $testResult->setQuestion($question->getText());
        $testResult->setAnswers([
            'user_answers'    => array_map(static fn (Answer $answer): string => (string) $answer->getText(), $userAnswers),
            'correct_answers' => array_map(
                static fn (Answer $answer): string => (string) $answer->getText(),
                array_filter($answers, static fn (Answer $answer): bool => $answer->isCorrect() || $answer->isFuzzyCorrect())
            ),
        ]);

        if ($question->isFuzzy()) {
            $validAnswers = array_merge($correctAnswers, $fuzzyCorrectAnswers);
            $userCorrectAnswers = array_intersect($userAnswerIds, $validAnswers);
            $testResult->setCorrect($this->isFuzzyCorrect($userCorrectAnswers, $userAnswers));
        } else {
            $testResult->setCorrect($this->isCorrect($correctAnswers, $userAnswerIds));
        }

        return $testResult;
    }

    /**
     * @param string[]                       $userCorrectAnswers
     * @param array<int, \App\Entity\Answer> $userAnswers
     *
     * @return bool
     */
    private function isFuzzyCorrect(array $userCorrectAnswers, array $userAnswers): bool
    {
        return count($userCorrectAnswers) === count($userAnswers) && count($userCorrectAnswers) > 0;
    }

    /**
     * @param string[] $correctAnswers
     * @param string[] $userAnswerIds
     *
     * @return bool
     */
    private function isCorrect(array $correctAnswers, array $userAnswerIds): bool
    {
        return array_diff($userAnswerIds, $correctAnswers) === [] && count($userAnswerIds) === count($correctAnswers);
    }

    /**
     * @param Answer[] $answers
     *
     * @return string[]
     */
    private function getCorrectAnswers(array $answers): array
    {
        return array_map(
            static fn (Answer $answer): string => (string) $answer->getId()?->toRfc4122(),
            array_filter($answers, static fn (Answer $answer): bool => (bool) $answer->isCorrect())
        );
    }

    /**
     * @param Answer[] $answers
     *
     * @return string[]
     */
    private function getFuzzyCorrectAnswers(array $answers): array
    {
        return array_map(
            static fn (Answer $answer): string => (string) $answer->getId()?->toRfc4122(),
            array_filter($answers, static fn (Answer $answer): bool => (bool) $answer->isFuzzyCorrect())
        );
    }
}
