<?php

namespace app\bundles\LoginBundle\Handler;

use app\bundles\LoginBundle\Descriptor\LoginDescriptor;
use app\bundles\LoginBundle\Exception\UserNotFoundException;

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
        //$user = $this->userManager->findOneBy(['email' => $descriptor->getEmail()]);

        //if($user === null) {
            throw new UserNotFoundException();
        //}

        $descriptor->setSuceeded(true);
    }
}
