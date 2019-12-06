<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="request")
 */
class Request {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\Column(type="string", length=128, nullable=true) */
    private $requestUuid;

    /** @ORM\Column(type="string", length=6, nullable=true) */
    private $status;

    /** @ORM\Column(type="string", length=64, nullable=true) */
    private $source;

    /** @ORM\Column(type="string", length=256, nullable=true) */
    private $requestUrl;

    /** @ORM\Column(type="string", length=64, nullable=true) */
    private $requestMethod;

    /** @ORM\Column(type="timestamp", length=6, nullable=true) */
    private $createdAt;
    
    /** @ORM\Column(type="timestamp", length=6, nullable=true) */
    private $endedAt;
    
    /** @ORM\Column(type="text", nullable=true) */
    private $params;

    public function getId() {
        return $this->id;
    }

    public function getRequestUuid() {
        return $this->requestUuid;
    }

    public function setRequestUuid($requestUuid) {
        $this->requestUuid = $requestUuid;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getSource() {
        return $this->source;
    }

    public function setSource($source) {
        $this->source = $source;
    }

    public function getRequestUrl() {
        return $this->requestUrl;
    }

    public function setRequestUrl($requestUrl) {
        $this->requestUrl = $requestUrl;
    }

    public function getRequestMethod() {
        return $this->requestMethod;
    }

    public function setRequestMethod($requestMethod) {
        $this->requestMethod = $requestMethod;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }
    
    public function getEndedAt() {
        return $this->endedAt;
    }

    public function setEndedAt($endedAt) {
        $this->endedAt = $endedAt;
    }
    
    public function getParams() {
        return $this -> params;
    }

}
