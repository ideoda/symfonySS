<?php

namespace app\bundles\CoreBundle\Interfaces;

/**
 * Interface RequestValidatorInterface
 * @package app\bundles\CoreBundle\Interfaces
 */
interface RequestValidatorInterface
{
    /**
     * @param string $formClass
     */
    public function validateForm(string $formClass): void;
}
