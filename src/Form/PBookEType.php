<?php

namespace App\Form;

use App\Entity\PBook;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PBookEType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('date')
            ->remove('book')
            ->remove('library')
            ->remove('status')
        ;
    }

    public function getParent()
    {
        return PBookType::class;
    }
}
