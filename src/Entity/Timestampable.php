<?php

namespace App\Entity;

/**
 * @package App\Entity
 */

// Nie klasa, a interface!!!!
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
