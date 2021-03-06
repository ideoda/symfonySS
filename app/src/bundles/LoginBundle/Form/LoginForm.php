<?php

namespace app\bundles\LoginBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class LoginForm
 * @package app\bundles\LoginBundle\Form
 */
class LoginForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'email',
            EmailType::class,
            [
                'required'    => true,
                'constraints' => [
                    new NotBlank(['message' => 'notblank'/*TODO*/]),
                    new Email(['message' => 'emailnotvalid'/*TODO*/]),
                ],
            ]
        );
        $builder->add(
            'password',
            PasswordType::class,
            [
                'required'    => true,
                'constraints' => [
                    new NotBlank(['message' => 'notblank'/*TODO*/]),
                ],
            ]
        );
        $builder->add(
            'save',
            SubmitType::class
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'csrf_protection' => false,
            ]);
    }
}
