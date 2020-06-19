<?php

namespace app\actions\login;

use app\bundles\CoreBundle\ActionHandler\AbstractWebActionHandler;
use app\bundles\CoreBundle\Descriptor\ErrorDescriptor;
use app\bundles\CoreBundle\Exception\FormValidationException;
use app\bundles\CoreBundle\Interfaces\DescriptorInterface;
use app\bundles\LoginBundle\Descriptor\LoginDescriptor;
use app\bundles\LoginBundle\Form\LoginForm;
use app\bundles\LoginBundle\Handler\LoginHandlerI;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PostLoginAction
 * @package app\actions\login
 */
class PostLoginAction extends AbstractWebActionHandler
{
    /**
     * @var LoginHandlerI
     */
    // TODO valamiért ha LoginHandler a class neve, akkor a file-t nem phpként ismeri fel a PHPstrom ezért tettem I-t a végére
    protected LoginHandlerI $loginHandler;

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
        if ($request->getMethod() === 'POST') {
            $this->requestValidator->validateForm(LoginForm::class);
        }
    }

    /**
     * @inheritDoc
     */
    protected function handle(Request $request): DescriptorInterface
    {
        $form = $this->createForm(LoginForm::class);

        $descriptor = new LoginDescriptor();
        $descriptor->setEmail($request->get('email'));
        $descriptor->setPassword($request->get('password'));

        $this->loginHandler->handle($descriptor);

        return $descriptor;
    }

    /**
     * @param \Exception $e
     * @return ErrorDescriptor
     */
    protected function handleError(\Exception $e): ErrorDescriptor
    {
        return new ErrorDescriptor($e);
    }

    /**
     * @inheritDoc
     */
    protected function createResponse(DescriptorInterface $descriptor): Response
    {
        if ($descriptor instanceof ErrorDescriptor) {

            if (($e = $descriptor->getError()) instanceof FormValidationException) {

                return $this->responder->createTwigResponse(
                    '@Login/login.form.html.twig',
                    [
                        'errors' => $e->getMessage(),
                    ]
                );
            }

            return $this->responder->createTwigErrorResponse($e);
        }

        $data = [
            'succeeded' => $descriptor->isSuceeded(),
        ];

        return $this->responder->createJsonResponse($data);
    }
}
