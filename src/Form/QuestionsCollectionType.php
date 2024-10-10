<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @codeCoverageIgnore Because of EntityType (it need really complex mocking)
 */
class QuestionsCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('questions', CollectionType::class, [
            'entry_type'    => QuestionType::class,
            'entry_options' => [
                'label' => false,
                'attr'  => [
                    'class' => 'question',
                ],
            ],
            'allow_add'    => true,
            'allow_delete' => true,
            'label'        => false,
            'attr'         => [
                'class' => 'question-form',
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
