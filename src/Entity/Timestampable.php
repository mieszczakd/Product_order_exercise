<?php

namespace App\Entity;

/**
 * @package App\Entity
 */
abstract class Timestampable
{

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * Timestampable constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

}