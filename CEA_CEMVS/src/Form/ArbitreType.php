<?php
namespace App\Form;
use App\Entity\Arbitre;
use App\Entity\ArbitreNiveau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class ArbitreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('niveau', EntityType::class, array(
            'class'=> ArbitreNiveau::class,
            'multiple' => false,
            'choice_label' => 'nom',
            'label'        => 'Selectionner le niveau',
            'expanded'     => false,
        ))->add('profils');
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Arbitre::class,
        ]);
    }
}