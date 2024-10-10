<?php

namespace App\Tests\Functional\Form;

use App\Entity\Answer;
use App\Form\AnswerType;
use Symfony\Component\Form\Test\TypeTestCase;

final class AnswerTypeTest extends TypeTestCase
{
    public function testSubmitValidData(): void
    {
        $formData = [
            'text' => 'Sample answer text',
        ];

        $model = new Answer();
        $form = $this->factory->create(AnswerType::class, $model);

        $expected = new Answer();
        $expected->setText('Sample answer text');

        $form->submit($formData);

        self::assertTrue($form->isSynchronized());
        self::assertEquals($expected, $model);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            self::assertArrayHasKey($key, $children);
        }
    }
}
