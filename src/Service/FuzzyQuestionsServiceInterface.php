<?php

namespace App\Service;

use App\Entity\Question;
use App\Entity\TestResult;

interface FuzzyQuestionsServiceInterface
{
    /**
     * @param Question $question
     *
     * @return TestResult
     */
    public function checkAnswers(Question $question): TestResult;
}
