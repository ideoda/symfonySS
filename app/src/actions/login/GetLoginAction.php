<?php

namespace app\actions\login;

use app\bundles\CoreBundle\ActionHandler\AbstractActionHandler;
use app\bundles\LoginBundle\Form\LoginForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GetLoginAction
 * @package app\actions\api\login
 */
class GetLoginAction extends AbstractActionHandler
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
    }

    /**
     * @inheritDoc
     */
    protected function handle(Request $request): Response
    {
        $form = $this->createForm(LoginForm::class);

        return $this->responder->createTwigResponse(
            '@Login/login.form.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @param \Exception $e
     * @return Response
     */
    protected function handleError(\Exception $e): Response
    {
        return $this->responder->createTwigResponse(
            '@Login/login.form.html.twig',
            [
                'errors' => $e->getMessage(),
            ]
        );
    }
}
