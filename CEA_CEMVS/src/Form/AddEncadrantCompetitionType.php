<?php
/**
 * Created by PhpStorm.
 * User: arino
 * Date: 05/07/2019
 * Time: 12:38
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use App\Entity\User;

class AddEncadrantCompetitionType extends AbstractType
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
            'label'        => 'Selectionner les encadrants pour ajouter a ce entrainement',
            'expanded'     => true,
        ));
    }
}