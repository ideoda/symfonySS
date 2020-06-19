<?php

namespace app\bundles\LoginBundle\Handler;

use app\bundles\LoginBundle\Descriptor\LoginDescriptor;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

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
        $user = $this->userManager->findOneBy(['email' => $descriptor->getEmail()]);

        if($user === null) {
            throw new UsernameNotFoundException();
        }

        $descriptor->setSuceeded(true);
    }
}
