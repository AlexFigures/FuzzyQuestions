<?php

namespace App\Entity;

use App\Repository\TestRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[ORM\Table(name: 'tests')]
#[ORM\Entity(repositoryClass: TestRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: 'uuid', unique: true, nullable: false, generated: 'INSERT')]
    private ?Uuid $id = null;

    #[ORM\Column]
    private ?DateTimeImmutable $completedAt = null;

    /**
     * @var Collection<int, TestResult>
     */
    #[ORM\OneToMany(targetEntity: TestResult::class, mappedBy: 'test', cascade: ['persist'], orphanRemoval: true)]
    private Collection $testResults;

    public function __construct()
    {
        $this->testResults = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    #[ORM\PrePersist]
    public function handleCompletedAtTime(): static
    {
        $this->completedAt = new DateTimeImmutable();

        return $this;
    }

    public function getCompletedAt(): ?DateTimeImmutable
    {
        return $this->completedAt;
    }

    /**
     * @return Collection<int, TestResult>
     */
    public function getTestResults(): Collection
    {
        return $this->testResults;
    }

    public function addTestResult(TestResult $testResult): static
    {
        if (!$this->testResults->contains($testResult)) {
            $this->testResults->add($testResult);
            $testResult->setTest($this);
        }

        return $this;
    }

    public function removeTestResult(TestResult $testResult): static
    {
        if ($this->testResults->removeElement($testResult)) {
            // set the owning side to null (unless already changed)
            if ($testResult->getTest() === $this) {
                $testResult->setTest(null);
            }
        }

        return $this;
    }
}
