<?php

namespace App\Tests\Fixtures;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class QuestionsFixtures extends Fixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $questionsData = [
            [
                'text'    => '1 + 1 =',
                'isFuzzy' => false,
                'answers' => [
                    ['text' => 3, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => 2, 'isCorrect' => true, 'isFuzzyCorrect' => false],
                    ['text' => 0, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                ],
            ],
            [
                'text'    => '2 + 2 =',
                'isFuzzy' => true,
                'answers' => [
                    ['text' => 4, 'isCorrect' => true, 'isFuzzyCorrect' => false],
                    ['text' => '3 + 1', 'isCorrect' => false, 'isFuzzyCorrect' => true],
                    ['text' => 10, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                ],
            ],
            [
                'text'    => '3 + 3 =',
                'isFuzzy' => true,
                'answers' => [
                    ['text' => '1 + 5', 'isCorrect' => false, 'isFuzzyCorrect' => true],
                    ['text' => 1, 'isCorrect' => true, 'isFuzzyCorrect' => false],
                    ['text' => 6, 'isCorrect' => true, 'isFuzzyCorrect' => false],
                    ['text' => '2 + 4', 'isCorrect' => false, 'isFuzzyCorrect' => true],
                ],
            ],
            [
                'text'    => '4 + 4 =',
                'isFuzzy' => true,
                'answers' => [
                    ['text' => 8, 'isCorrect' => true, 'isFuzzyCorrect' => false],
                    ['text' => 4, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => 0, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => '0 + 8', 'isCorrect' => false, 'isFuzzyCorrect' => true],
                ],
            ],
            [
                'text'    => '5 + 5 =',
                'isFuzzy' => false,
                'answers' => [
                    ['text' => 6, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => 18, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => 10, 'isCorrect' => true, 'isFuzzyCorrect' => false],
                    ['text' => 9, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => 0, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                ],
            ],
            [
                'text'    => '6 + 6 =',
                'isFuzzy' => true,
                'answers' => [
                    ['text' => 3, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => 9, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => 0, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => 12, 'isCorrect' => true, 'isFuzzyCorrect' => false],
                    ['text' => '5 + 7', 'isCorrect' => false, 'isFuzzyCorrect' => true],
                ],
            ],
            [
                'text'    => '7 + 7 =',
                'isFuzzy' => false,
                'answers' => [
                    ['text' => 5, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => 14, 'isCorrect' => true, 'isFuzzyCorrect' => false],
                ],
            ],
            [
                'text'    => '8 + 8 =',
                'isFuzzy' => false,
                'answers' => [
                    ['text' => 16, 'isCorrect' => true, 'isFuzzyCorrect' => false],
                    ['text' => 12, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => 9, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => 5, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                ],
            ],
            [
                'text'    => '9 + 9 =',
                'isFuzzy' => true,
                'answers' => [
                    ['text' => 18, 'isCorrect' => true, 'isFuzzyCorrect' => false],
                    ['text' => 9, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => '17 + 1', 'isCorrect' => false, 'isFuzzyCorrect' => true],
                    ['text' => '2 + 16', 'isCorrect' => false, 'isFuzzyCorrect' => true],
                ],
            ],
            [
                'text'    => '10 + 10 =',
                'isFuzzy' => false,
                'answers' => [
                    ['text' => 0, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => 2, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => 8, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => 20, 'isCorrect' => true, 'isFuzzyCorrect' => false],
                ],
            ],
        ];

        foreach ($questionsData as $data) {
            $question = new Question();
            $question->setText($data['text']);
            $question->setFuzzy($data['isFuzzy']);
            $manager->persist($question);

            foreach ($data['answers'] as $answerData) {
                $answer = new Answer();
                $answer->setText((string) $answerData['text']);
                $answer->setCorrect($answerData['isCorrect']);
                $answer->setFuzzyCorrect($answerData['isFuzzyCorrect']);
                $answer->setQuestion($question);
                $manager->persist($answer);
            }
        }

        $manager->flush();
    }
}
