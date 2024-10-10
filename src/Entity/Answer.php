<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: AnswerRepository::class)]
class Answer
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: 'uuid', unique: true, nullable: false, generated: 'INSERT')]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(targetEntity: Question::class, inversedBy: 'answers')]
    private ?Question $question = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column]
    private ?bool $isCorrect = null;

    #[ORM\Column]
    private ?bool $isFuzzyCorrect = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

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

    public function isFuzzyCorrect(): ?bool
    {
        return $this->isFuzzyCorrect;
    }

    public function setFuzzyCorrect(bool $isFuzzyCorrect): static
    {
        $this->isFuzzyCorrect = $isFuzzyCorrect;

        return $this;
    }
}
