<?php

namespace Icetig\Bundle\ApiBundle\Entity;

use DateTime;
use Icetig\Bundle\UserBundle\Entity\User;

/**
 * Access
 */
class Access
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var string
     */
    protected $signatureToken;

    /**
     * @var DateTime
     */
    protected $generationDate;

    /**
     * @var DateTime
     */
    protected $expirationDate;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getSignatureToken(): string
    {
        return $this->signatureToken;
    }

    /**
     * @param string $signatureToken
     */
    public function setSignatureToken(string $signatureToken)
    {
        $this->signatureToken = $signatureToken;
    }

    /**
     * @return DateTime
     */
    public function getGenerationDate(): DateTime
    {
        return $this->generationDate;
    }

    /**
     * @param DateTime $generationDate
     */
    public function setGenerationDate(DateTime $generationDate)
    {
        $this->generationDate = $generationDate;
    }

    /**
     * @return DateTime
     */
    public function getExpirationDate(): DateTime
    {
        return $this->expirationDate;
    }

    /**
     * @param DateTime $expirationDate
     */
    public function setExpirationDate(DateTime $expirationDate)
    {
        $this->expirationDate = $expirationDate;
    }

    public function getData()
    {
        $data = [];
        $data['user'] = $this->user->getData();
        $data['signatureToken'] = $this->signatureToken;
        $data['generationDate'] = $this->generationDate->getTimestamp();
        $data['expirationDate'] = $this->expirationDate->getTimestamp();

        return $data;
    }
}

