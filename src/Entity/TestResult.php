<?php

namespace App\Entity;

use App\Repository\TestResultRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TestResultRepository::class)]
class TestResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: 'uuid', unique: true, nullable: false, generated: 'INSERT')]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(inversedBy: 'testResults')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Test $test = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $question = null;

    /** @var array{user_answers: string[], correct_answers: string[]} */
    #[ORM\Column(type: Types::JSON)]
    private array $answers = ['user_answers' => [], 'correct_answers' => []];

    #[ORM\Column]
    private ?bool $isCorrect = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getTest(): ?Test
    {
        return $this->test;
    }

    public function setTest(?Test $test): static
    {
        $this->test = $test;

        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(?string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function isCorrect(): ?bool
    {
        return $this->isCorrect;
    }

    public function setCorrect(bool $isCorrect): static
    {
        $this->isCorrect = $isCorrect;

        return $this;
    }

    /**
     * @param array{user_answers: string[], correct_answers: string[]} $answers
     *
     * @return $this
     */
    public function setAnswers(array $answers): TestResult
    {
        $this->answers = $answers;

        return $this;
    }

    /**
     * @return array{user_answers: string[], correct_answers: string[]}
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }
}
