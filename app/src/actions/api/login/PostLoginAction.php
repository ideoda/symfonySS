<?php

namespace app\actions\api\login;

use app\bundles\CoreBundle\ActionHandler\AbstractApiActionHandler;
use app\bundles\LoginBundle\Descriptor\LoginDescriptor;
use app\bundles\LoginBundle\Form\LoginForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PostLoginAction
 * @package app\actions\api\login
 */
class PostLoginAction extends AbstractApiActionHandler
{
    /**
     * @inheritDoc
     */
    protected function getAllowedRoles()
    {
    }

    /**
     * @inheritDoc
     */
    protected function validateRequest(Request $request): void
    {
        $this->requestValidator->validateForm(LoginForm::class);
    }

    /**
     * @inheritDoc
     */
    protected function handle(Request $request): Response
    {
        $descriptor = new LoginDescriptor();
        $descriptor->setEmail($request->get('email'));
        $descriptor->setPassword($request->get('password'));

        $this->loginHandler->handle($descriptor);

        // TODO külön responder kell
        return $this->responder->createJsonResponse(
            [
                'succeeded' => $descriptor->isSuceeded(),
            ]
        );
    }
}
