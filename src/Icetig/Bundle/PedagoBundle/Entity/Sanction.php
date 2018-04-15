<?php

namespace Icetig\Bundle\PedagoBundle\Entity;
use Icetig\Bundle\UserBundle\Entity\User;

/**
 * Sanction
 */
class Sanction
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var User
     */
    private $subject;

    /**
     * @var User
     */
    private $issuer;

    /**
     * @var int
     */
    private $state;

    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * @var \DateTime
     */
    private $endDate;

    /**
     * @var string
     */
    private $reason;

    /**
     * @var string
     */
    private $task;

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Sanction
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set subject
     *
     * @param User $subject
     *
     * @return Sanction
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return User
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set issuer
     *
     * @param User $issuer
     *
     * @return Sanction
     */
    public function setIssuer($issuer)
    {
        $this->issuer = $issuer;

        return $this;
    }

    /**
     * Get issuer
     *
     * @return User
     */
    public function getIssuer()
    {
        return $this->issuer;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Sanction
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Sanction
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Sanction
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     */
    public function setReason(string $reason)
    {
        $this->reason = $reason;
    }

    /**
     * @return string
     */
    public function getTask(): string
    {
        return $this->task;
    }

    /**
     * @param string $task
     */
    public function setTask(string $task)
    {
        $this->task = $task;
    }

    public function getShortData()
    {
        $data = [];

        $data['id'] = $this->id;
        $data['date'] = $this->date;
        $data['subject'] = $this->issuer->getId();
        $data['issuer'] = $this->issuer->getId();
        $data['state'] = $this->state;
        $data['startDate'] = $this->startDate;
        $data['endDate'] = $this->endDate;
        $data['reason'] = $this->reason;
        $data['task'] = $this->task;

        return $data;
    }
}

