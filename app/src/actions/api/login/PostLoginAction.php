<?php

namespace app\actions\api\login;

use app\bundles\CoreBundle\ActionHandler\AbstractApiActionHandler;
use app\bundles\CoreBundle\Descriptor\ErrorDescriptor;
use app\bundles\CoreBundle\Interfaces\DescriptorInterface;
use app\bundles\CoreBundle\Responder\Responder;
use app\bundles\CoreBundle\Validator\RequestValidator;
use app\bundles\LoginBundle\Descriptor\LoginDescriptor;
use app\bundles\LoginBundle\Form\LoginForm;
use app\bundles\LoginBundle\Handler\LoginHandlerI;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PostLoginAction
 * @package app\actions\api\login
 */
class PostLoginAction extends AbstractApiActionHandler
{
    /**
     * @var LoginHandlerI
     */
    protected LoginHandlerI $loginHandler;

    /**
     * PostLoginAction constructor.
     * @param RequestValidator $requestValidator
     * @param Responder        $responder
     * @param LoginHandlerI    $loginHandler
     */
    public function __construct(
        RequestValidator $requestValidator,
        Responder $responder,
        LoginHandlerI $loginHandler
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
    protected function handle(Request $request): DescriptorInterface
    {
        $descriptor = new LoginDescriptor();
        $descriptor->setEmail($request->get('email'));
        $descriptor->setPassword($request->get('password'));

        $this->loginHandler->handle($descriptor);

        return $descriptor;
    }

    /**
     * @inheritDoc
     */
    protected function handleError(\Exception $e): ErrorDescriptor
    {
        return new ErrorDescriptor($e);
    }

    /**
     * @param DescriptorInterface $descriptor
     * @return Response
     */
    protected function createResponse(DescriptorInterface $descriptor): Response
    {
        /** @var LoginDescriptor $descriptor */

        $data = [
            'succeeded' => $descriptor->isSuceeded()
        ];

        return $this->responder->createJsonResponse($data);
    }

}
