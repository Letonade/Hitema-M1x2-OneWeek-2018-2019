<?php
/**
 * Created by PhpStorm.
 * User: arino
 * Date: 05/07/2019
 * Time: 11:32
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use App\Entity\User;

class AddCompititeurCompetitionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Tireurs', EntityType::class, array(
            'class'=> User::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->andWhere('u.role = :role')
                    ->setParameter('role', 1);
            },
            'multiple' => true,
            'choice_label' => 'login',
            'label'        => 'Selectionner les competiteurs pour ajouter a ce entrainement',
            'expanded'     => true,
        ));
    }

}