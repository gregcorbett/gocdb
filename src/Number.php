<?php
// src/Number.php
/**
 * @Entity @Table(name="numbers")
 **/
class Number
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    
    /** @Column(type="integer") **/
    protected $number;

    /** @Column(type="string") **/
    protected $parity;

    public function getId()
    {
        return $this->id;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        $this->number= $number;
    }
    
    public function getParity()
    {
        return $this->parity;
    }

    public function setParity($parity)
    {
        $this->parity= $parity;
    }
}