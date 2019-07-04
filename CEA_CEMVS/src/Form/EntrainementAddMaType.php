<?php
/**
 * Created by PhpStorm.
 * User: arino
 * Date: 04/07/2019
 * Time: 21:22
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class EntrainementAddMaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('MAs', EntityType::class, array(
            'class'=> User::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->andWhere('u.role = :role')
                    ->setParameter('role', 2);
            },
            'multiple' => true,
            'choice_label' => 'login',
            'label'        => 'Selectionner les maitres d\'armes pour ajouter a ce entrainement',
            'expanded'     => true,
        ));
    }

}