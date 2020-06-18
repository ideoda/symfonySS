<?php

namespace app\actions\api\login;

use app\bundles\CoreBundle\ActionHandler\AbstractActionHandler;
use app\bundles\LoginBundle\Descriptor\LoginDescriptor;
use app\bundles\LoginBundle\Form\LoginForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PostLoginAction
 * @package app\actions\api\login
 */
class PostLoginAction extends AbstractActionHandler
{
    /**
     * @inheritDoc
     */
    protected function getAllowedRoles()
    {}

    /**
     * @inheritDoc
     */
    protected function validate(Request $request): void
    {
        $this->requestValidator->validateForm($request, LoginForm::class);
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

        return $this->responder->createJsonResponse(
            [
                'succeeded' => $descriptor->isSuceeded(),
            ]
        );
    }

    /**
     * @inheritDoc
     */
    protected function handleError(\Exception $e, Request $request): Response
    {
        return $this->responder->createJsonResponse(
            [
                'errorClass'   => \get_class($e),
                'errorMessage' => $e->getMessage(),
            ]
        );
    }
}
