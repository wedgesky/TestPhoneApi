<?php

namespace App\Entity;

use App\Repository\TestPhoneRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TestPhoneRepository::class)
 */
class TestPhone
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sms_phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $result;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reason;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSmsPhone(): ?string
    {
        return $this->sms_phone;
    }

    public function setSmsPhone(string $sms_phone): self
    {
        $this->sms_phone = $sms_phone;

        return $this;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(string $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }
}
