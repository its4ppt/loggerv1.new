<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="log")
 */
class Log {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\Column(type="string", length=128, nullable=true) */
    private $requestUuid;

    /** @ORM\Column(type="string", length=128, nullable=true) */
    private $tag;

    /** @ORM\Column(type="string", length=64, nullable=true) */
    private $logLevel;

    /** @ORM\Column(type="text", nullable=true) */
    private $message;

    /** @ORM\Column(type="timestamp", length=6, nullable=true) */
    private $createdAt;
    
    /** @ORM\ManyToOne(targetEntity="Request") */
    private $request;

    public function getId() {
        return $this->id;
    }

    public function getRequestUuid() {
        return $this->requestUuid;
    }

    public function setRequestUuid($requestUuid) {
        $this->requestUuid = $requestUuid;
    }

    public function getTag() {
        return $this->tag;
    }

    public function setTag($tag) {
        $this->tag = $tag;
    }

    public function getLogLevel() {
        return $this->logLevel;
    }

    public function setLogLevel($logLevel) {
        $this->logLevel = $logLevel;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }
    
    public function getRequest() {
        return $this->request;
    }

    public function setRequest($request) {
        $this->request = $request;
    }

}
