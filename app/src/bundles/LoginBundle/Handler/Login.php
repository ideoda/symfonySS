<?php

namespace app\bundles\LoginBundle\Handler;

use app\bundles\LoginBundle\Descriptor\LoginDescriptor;

/**
 * Class Login
 * @package app\bundles\LoginBundle\Handler
 */
class Login
{
    /**
     * @param LoginDescriptor $descriptor
     */
    public function handle(LoginDescriptor $descriptor): void
    {
        $descriptor->setSuceeded(true);
    }
}
