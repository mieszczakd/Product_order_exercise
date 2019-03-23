<?php

namespace App\Entity;


/**
 * Interface Timestampable
 * @package App\Entity
 */
interface Timestampable
{
    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime;
}