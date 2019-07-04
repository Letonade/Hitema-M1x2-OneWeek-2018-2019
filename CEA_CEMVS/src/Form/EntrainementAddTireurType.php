<?php
/**
 * Created by PhpStorm.
 * User: arino
 * Date: 04/07/2019
 * Time: 21:21
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class EntrainementAddTireurType extends AbstractType
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
           'label'        => 'Selectionner les tireurs pour ajouter a ce entrainement',
           'expanded'     => true,
       ));
    }

}