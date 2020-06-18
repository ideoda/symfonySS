<?php

namespace app\bundles\CoreBundle\Interfaces;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface RequestValidatorInterface
 * @package app\bundles\CoreBundle\Interfaces
 */
interface RequestValidatorInterface
{
    /**
     * @param Request $request
     * @param string  $formClass
     */
    public function validateForm(Request $request, string $formClass): void;
}
