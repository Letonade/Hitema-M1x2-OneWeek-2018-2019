<?php
/**
 * Created by PhpStorm.
 * User: arino
 * Date: 13/11/2018
 * Time: 09:23
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait IdTrait
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function getId()
    {
        return $this->id;
    }
}