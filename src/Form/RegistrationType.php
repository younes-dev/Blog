<?php

namespace App\Form;

use App\Entity\User;
use phpDocumentor\Reflection\Types\Self_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    const CLASS_NAME = 'class';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,['attr' => [RegistrationType::CLASS_NAME => 'c1']])
            ->add('username',TextType::class,['attr' => [RegistrationType::CLASS_NAME  => 'c2']])
            ->add('password',PasswordType::class,['attr' => [RegistrationType::CLASS_NAME => 'c2']])
            ->add('confirm_password',PasswordType::class,['attr' => [RegistrationType::CLASS_NAME => 'c2']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
//    registration
}
