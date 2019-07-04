<?php
/**
 * Created by PhpStorm.
 * User: arino
 * Date: 04/07/2019
 * Time: 10:02
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CsvImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('csv', FileType::class);
    }

}