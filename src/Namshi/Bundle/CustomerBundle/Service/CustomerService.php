<?php
/**
 * Created by PhpStorm.
 * User: ilham
 * Date: 10/27/14
 * Time: 1:12 AM
 */

namespace Namshi\Bundle\CustomerBundle\Service;

use Doctrine\ORM\EntityManager;

class CustomerService
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    public $model;

    protected $em;

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