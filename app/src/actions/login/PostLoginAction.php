<?php

namespace app\actions\login;

use app\bundles\CoreBundle\ActionHandler\AbstractActionHandler;
use app\bundles\CoreBundle\Exception\FormValidationException;
use app\bundles\CoreBundle\Responder\Responder;
use app\bundles\CoreBundle\Validator\RequestValidator;
use app\bundles\LoginBundle\Descriptor\LoginDescriptor;
use app\bundles\LoginBundle\Form\LoginForm;
use app\bundles\LoginBundle\Handler\LogiinHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PostLoginAction
 * @package app\actions\login
 */
class PostLoginAction extends AbstractActionHandler
{
    /**
     * @var LogiinHandler
     */
    protected LogiinHandler $loginHandler;

    /**
     * PostLoginAction constructor.
     * @param RequestValidator $requestValidator
     * @param Responder        $responder
     * @param LogiinHandler    $loginHandler
     */
    public function __construct(
        RequestValidator $requestValidator,
        Responder $responder,
        LogiinHandler $loginHandler
    ) {
        $this->loginHandler = $loginHandler;
        parent::__construct($requestValidator, $responder);
    }

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
        $descriptor->setEmail($request->request->all()['login_form']['email']);
        $descriptor->setPassword($request->request->all()['login_form']['password']);

        $this->loginHandler->handle($descriptor);

        return $this->responder->createTwigResponse(
            '@Login/login.form.success.html.twig',
            []
        );
    }

    /**
     * @param \Exception $e
     * @return Response
     */
    protected function handleError(\Exception $e): Response
    {
        if ($e instanceof FormValidationException) {
            return $this->responder->createTwigResponse(
                '@Login/login.form.html.twig',
                [
                    'errors' => $e->getFormErrors(),
                ]
            );
        }
    }
}
