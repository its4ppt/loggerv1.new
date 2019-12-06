<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="user")
 */
class User {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /** @ORM\Column(type="string", nullable=false, unique=true) */
    private $email;
    
    /** @ORM\Column(type="string", length=32, nullable=false) */
    private $password;
    
    /** @ORM\Column(type="string", length=16, nullable=true) */
    private $firstName;
    
    /** @ORM\Column(type="string", length=16, nullable=true) */
    private $lastName;
    
    /** @ORM\Column(type="string", length=16, nullable=true) */
    private $roleCode;
    
    /** @ORM\Column(type="datetime", nullable=false) */
    private $createdAt;
    
    /** @ORM\Column(type="boolean", nullable=false) */
    private $isApproved;
    
    
    public function getId(){
            return $this->id;
    }

    public function setId($id){
            $this->id = $id;
    }

    public function getEmail(){
            return $this->email;
    }

    public function setEmail($email){
            $this->email = $email;
    }

    public function getPassword(){
            return $this->password;
    }

    public function setPassword($password){
            $this->password = $password;
    }
    
    public function getFirstName(){
            return $this->firstName;
    }

    public function setFirstName($firstName){
            $this->firstName = $firstName;
    }

    public function getLastName(){
            return $this->lastName;
    }

    public function setLastName($lastName){
            $this->lastName = $lastName;
    }

    public function getCreatedAt(){
            return $this->createdAt;
    }

    public function setCreatedAt($createdAt){
            $this->createdAt = $createdAt;
    }
    
    public function getRoleCode() {
        return $this -> roleCode;
    }
    
    public function setRoleCode($roleCode) {
        $this -> roleCode = $roleCode;
    }
    
    public function getIsApproved() {
        return $this -> isApproved;
    }
    
    public function setIsApproved($isApproved) {
        return $this -> isApproved = $isApproved;
    }
}