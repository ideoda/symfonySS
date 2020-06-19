<?php

namespace app\actions\login;

use app\bundles\CoreBundle\ActionHandler\AbstractWebActionHandler;
use app\bundles\CoreBundle\Exception\FormValidationException;
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
    protected function validateRequest(Request $request): void
    {
        $this->requestValidator->validateForm(LoginForm::class);
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
     * @param Request    $request
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function handleError(\Exception $e, Request $request): Response
    {
        if ($e instanceof FormValidationException) {
            return $this->responder->createTwigResponse(
                '@Login/login.form.html.twig',
                [
                    'errors' => $e->getFormErrors(),
                ]
            );
        }

        return parent::handleError($e, $request);
    }
}
