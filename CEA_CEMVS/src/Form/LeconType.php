<?php
namespace App\Form;
use App\Entity\Entrainement;
use App\Entity\Lecon;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class LeconType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tireur_id', EntityType::class, array(
                'class' => lecon::class,
                'choice_label' => 'idTireur'
            ))
            ->add('ma_id', EntityType::class, array(
                'class' => lecon::class,
                'choice_label' => 'idMaitre'
            ))

            ->add('entrainement_id',EntityType::class, array(
                'class' => lecon::class,
                'choice_label' =>'idEntrainement'))
            ->add('texte_tireur',EntityType::class, array(
                    'class' => lecon::class,
                    'choice_label' =>'texte_tireur',
                    'allow_add' => true,
                    'allow_delete' => true,
    
                    ))
                    ->add('texte_maitre',EntityType::class, array(
                        'class' => lecon::class,
                        'choice_label' =>'texte_maitre',
                        'allow_add' => true,
                        'allow_delete' => true,
        
                        ))
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lecon::class,
        ]);
    }
}