<?php

namespace app\bundles\LoginBundle\Handler;

use app\bundles\LoginBundle\Descriptor\LoginDescriptor;

/**
 * Class LoginHandlerI
 * @package app\bundles\LoginBundle\Handler
 */
class LoginHandlerI
{
    /**
     * @param LoginDescriptor $descriptor
     */
    public function handle(LoginDescriptor $descriptor): void
    {
        $descriptor->setSuceeded(true);
    }
}
