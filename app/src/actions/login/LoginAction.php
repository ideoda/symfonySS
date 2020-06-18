<?php

namespace app\actions\login;

use app\bundles\CoreBundle\ActionHandler\AbstractActionHandler;
use app\bundles\LoginBundle\Form\LoginForm;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LoginAction
 * @package app\actions\api\login
 */
class LoginAction extends AbstractActionHandler
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
     * @inheritDoc
     */
    protected function handleError(\Exception $e, Request $request): Response
    {
        return new JsonResponse(['error' => 'error']);
    }
}
