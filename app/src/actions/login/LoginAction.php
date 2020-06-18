<?php

namespace app\actions\login;

use app\bundles\CoreBundle\ActionHandler\AbstractWebActionHandler;
use app\bundles\LoginBundle\Form\LoginForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LoginAction
 * @package app\actions\api\login
 */
class LoginAction extends AbstractWebActionHandler
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
    protected function validate(Request $request): void
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
}
