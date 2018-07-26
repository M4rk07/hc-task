<?php
/**
 * Created by PhpStorm.
 * User: M4rk0
 * Date: 7/25/2018
 * Time: 9:44 PM
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="hc_trip")
 */
class Trip
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id_trip;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Regex("/^.{3,}$/")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="trips")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getIdTrip()
    {
        return $this->id_trip;
    }

    /**
     * @param mixed $id_trip
     */
    public function setIdTrip($id_trip): void
    {
        $this->id_trip = $id_trip;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }





}