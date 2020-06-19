<?php

namespace app\actions\login;

use app\bundles\CoreBundle\ActionHandler\AbstractWebActionHandler;
use app\bundles\CoreBundle\Descriptor\ErrorDescriptor;
use app\bundles\CoreBundle\Descriptor\FormDescriptor;
use app\bundles\CoreBundle\Exception\FormValidationException;
use app\bundles\CoreBundle\Interfaces\DescriptorInterface;
use app\bundles\LoginBundle\Form\LoginForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GetLoginAction
 * @package app\actions\api\login
 */
class GetLoginAction extends AbstractWebActionHandler
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
    protected function handle(Request $request): DescriptorInterface
    {
        $form = $this->createForm(LoginForm::class);

        $descriptor = (new FormDescriptor());
        $descriptor->setForm($form);

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

        if ($descriptor instanceof FormDescriptor) {
            return $this->responder->createTwigResponse(
                '@Login/login.form.html.twig',
                ['form' => $descriptor->getForm()->createView()]
            );
        }
    }
}
