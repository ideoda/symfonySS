<?php

namespace app\bundles\LoginBundle\Handler;

use app\bundles\LoginBundle\Descriptor\LoginDescriptor;

/**
 * Class LoginHandlerI
 * @package app\bundles\LoginBundle\Handler
 */
class LogiinHandler // TODO valamiért ha LoginHandler a class neve, akkor a file-t nem phpként ismeri fel a PHPstrom ezért ez a neve egyelőre
{
    /**
     * @param LoginDescriptor $descriptor
     */
    public function handle(LoginDescriptor $descriptor): void
    {
        $descriptor->setSuceeded(true);
    }
}
