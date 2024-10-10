<?php

declare(strict_types=1);

namespace Doctrine\Migrations;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241009134813 extends AbstractMigration implements \App\Migrations\EntityManagerAwareInterface
{
    private EntityManagerInterface $entityManager;

    public function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }

    public function getDescription(): string
    {
        return 'Init questions';
    }

    public function up(Schema $schema): void
    {
        $questionsData = [
            [
                'text' => '1 + 1 =',
                'isFuzzy' => false,
                'answers' => [
                    ['text' => 3, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => 2, 'isCorrect' => true, 'isFuzzyCorrect' => false],
                    ['text' => 0, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                ],
            ],
            [
                'text' => '2 + 2 =',
                'isFuzzy' => true,
                'answers' => [
                    ['text' => 4, 'isCorrect' => true, 'isFuzzyCorrect' => false],
                    ['text' => '3 + 1', 'isCorrect' => false, 'isFuzzyCorrect' => true],
                    ['text' => 10, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                ],
            ],
            [
                'text' => '3 + 3 =',
                'isFuzzy' => true,
                'answers' => [
                    ['text' => '1 + 5', 'isCorrect' => false, 'isFuzzyCorrect' => true],
                    ['text' => 1, 'isCorrect' => true, 'isFuzzyCorrect' => false],
                    ['text' => 6, 'isCorrect' => true, 'isFuzzyCorrect' => false],
                    ['text' => '2 + 4', 'isCorrect' => false, 'isFuzzyCorrect' => true],
                ],
            ],
            [
                //4 + 4 =
                //
                //8
                //4
                //0
                //0 + 8
                //
                //Правильный ответ: 1 ИЛИ 4 ИЛИ (1 И 4)
                'text' => '4 + 4 =',
                'isFuzzy' => true,
                'answers' => [
                    ['text' => 8, 'isCorrect' => true, 'isFuzzyCorrect' => false],
                    ['text' => 4, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => 0, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => '0 + 8', 'isCorrect' => false, 'isFuzzyCorrect' => true],
                ],
            ],
            [
                //5 + 5 =
                //
                //6
                //18
                //10
                //9
                //0
                //
                //Правильный ответ: 3
                'text' => '5 + 5 =',
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
                //6 + 6 =
                //
                //3
                //9
                //0
                //12
                //5 + 7
                //
                //Правильный ответ: 4 ИЛИ 5 ИЛИ (4 И 5)
                'text' => '6 + 6 =',
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
                //7 + 7 =
                //
                //5
                //14
                //
                //Правильный ответ: 2
                'text' => '7 + 7 =',
                'isFuzzy' => false,
                'answers' => [
                    ['text' => 5, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => 14, 'isCorrect' => true, 'isFuzzyCorrect' => false],
                ],
            ],
            [
                //8 + 8 =
                //
                //16
                //12
                //9
                //5
                //
                //Правильный ответ: 1
                'text' => '8 + 8 =',
                'isFuzzy' => false,
                'answers' => [
                    ['text' => 16, 'isCorrect' => true, 'isFuzzyCorrect' => false],
                    ['text' => 12, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => 9, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => 5, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                ],
            ],
            [
                //9 + 9 =
                //
                //18
                //9
                //17 + 1
                //2 + 16
                //
                //Правильный ответ: 1 ИЛИ 3 ИЛИ 4 ИЛИ (1 И 3) ИЛИ (1 И 4) ИЛИ (3 И 4) ИЛИ (1 И 3 И 4)
                'text' => '9 + 9 =',
                'isFuzzy' => true,
                'answers' => [
                    ['text' => 18, 'isCorrect' => true, 'isFuzzyCorrect' => false],
                    ['text' => 9, 'isCorrect' => false, 'isFuzzyCorrect' => false],
                    ['text' => '17 + 1', 'isCorrect' => false, 'isFuzzyCorrect' => true],
                    ['text' => '2 + 16', 'isCorrect' => false, 'isFuzzyCorrect' => true],
                ],
            ],
            [
                //10 + 10 =
                //
                //0
                //2
                //8
                //20
                //
                //Правильный ответ: 4
                'text' => '10 + 10 =',
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
            $this->entityManager->persist($question);

            foreach ($data['answers'] as $answerData) {
                $answer = new Answer();
                $answer->setText((string) $answerData['text']);
                $answer->setCorrect($answerData['isCorrect']);
                $answer->setFuzzyCorrect($answerData['isFuzzyCorrect']);
                $answer->setQuestion($question);
                $this->entityManager->persist($answer);
            }
        }

        $this->entityManager->flush();

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM answer where 1=1');
        $this->addSql('DELETE FROM question where 1=1');
    }
}
