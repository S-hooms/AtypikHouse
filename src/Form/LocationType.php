<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Option;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('surface')
            ->add('pieces')
            ->add('chambres')
            ->add('etage')
            ->add('prix')
            ->add('chauffage', ChoiceType::class, [
                'choices' => $this->getChoices()
            ])
            ->add('options', EntityType::class, [
                'class' => Option::class,
                'required' => false,
                'choice_label' => 'nom',
                'multiple' => true
            ])
            ->add('imageFile', FileType::class, [
                'required' => false
            ])
            ->add('ville')
            ->add('addresse')
            ->add('code_postal')
            ->add('louer')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
            'translation_domain' => 'forms'
        ]);
    }

    private function getChoices()
    {
        $choices = Location::Chauffage;
        $output = [];
        foreach($choices as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }
}
