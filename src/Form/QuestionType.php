<?php

namespace App\Form;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @codeCoverageIgnore Because of EntityType (it need really complex mocking)
 */
class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text', TextType::class, [
                'attr'  => ['readonly' => true, 'class' => 'question-text'],
                'label' => false,
            ])
            ->addEventListener(FormEvents::POST_SET_DATA, static function (FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();
                if (!$data instanceof Question) {
                    return;
                }
                $form->add('answers', EntityType::class, [
                    'class'         => Answer::class,
                    'choice_label'  => 'text',
                    'label'         => false,
                    'multiple'      => true,
                    'expanded'      => true,
                    'query_builder' => static function (EntityRepository $er) use ($data) {
                        return $er->createQueryBuilder('a')
                            ->leftJoin('a.question', 'q')
                            ->where('q.id = :question_id')
                            ->setParameter('question_id', $data->getId());
                    },
                    'attr' => ['class' => 'answer'],
                    'data' => [],
                ]);
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
