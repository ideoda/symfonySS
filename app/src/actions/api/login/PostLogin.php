<?php

namespace app\actions\api\login;

use app\bundles\CoreBundle\ActionHandler\AbstractAction;
use app\bundles\CoreBundle\Responder\Responder;
use app\bundles\CoreBundle\Validator\RequestValidator;
use app\bundles\LoginBundle\Descriptor\LoginDescriptor;
use app\bundles\LoginBundle\Form\LoginForm;
use app\bundles\LoginBundle\Handler\LogiinHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PostLoginAction
 * @package app\actions\api\login
 */
class PostLogin extends AbstractAction
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
        $descriptor->setEmail($request->get('email'));
        $descriptor->setPassword($request->get('password'));

        $this->loginHandler->handle($descriptor);

        return $this->responder->createJsonResponse(
            [
                'succeeded' => $descriptor->isSuceeded(),
            ]);
    }

    /**
     * @inheritDoc
     */
    protected function handleError(\Exception $e): Response
    {
        return $this->responder->createJsonResponse(
            [
                'error' => $e->getMessage(),
            ]);
    }
}
