<?php

namespace Namshi\Bundle\PhoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \JMS\Serializer\Annotation\Groups;

/**
 * Phone
 *
 * @ORM\Table(name="phone", options={"collate"="utf8_general_ci"})
 * @ORM\Entity
 */
class Phone
{
    const STATUS_ACTIVE     = 'active';
    const STATUS_PASSIVE    = 'passive';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=255)
     *
     * @Groups({"api"})
     */
    private $number;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="string", columnDefinition="ENUM('active', 'passive')")
     *
     * @Groups({"api"})
     */
    protected $status;


    /**
     * @var \Namshi\Bundle\CustomerBundle\Entity\Customer
     * @ORM\ManyToOne(targetEntity="Namshi\Bundle\CustomerBundle\Entity\Customer", inversedBy="products")
     * @ORM\JoinColumn(name="customerId", referencedColumnName="id")
     *
     */
    protected $customer;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set number
     *
     * @param string $number
     * @return Phone
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param $status
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setStatus($status)
    {
        if (!in_array($status, self::getStatusList())) {
            throw new \InvalidArgumentException("Invalid type");
        }
        $this->status = $status;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public static function getStatusList()
    {
        return array(
            self::STATUS_ACTIVE,
            self::STATUS_PASSIVE
        );
    }

    /**
     * @param \Namshi\Bundle\CustomerBundle\Entity\Customer $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return \Namshi\Bundle\CustomerBundle\Entity\Customer $customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    public function __toString()
    {
        return (string) $this->number;
    }
}
