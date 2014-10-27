<?php
/**
 * Created by PhpStorm.
 * User: ilham
 * Date: 10/27/14
 * Time: 1:43 AM
 */

namespace Namshi\Bundle\PhoneBundle\Service;

use Doctrine\ORM\EntityManager;

class PhoneService
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    public $model;

    public $em;

    /**
     * @param EntityManager $em
     * @param $entityName
     */
    public function __construct(EntityManager $em, $entityName)
    {
        $this->em = $em;
        $this->model = $em->getRepository($entityName);
    }
} 