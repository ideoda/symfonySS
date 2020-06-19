<?php

namespace app\bundles\CoreBundle\Validator;

use app\bundles\CoreBundle\Exception\FormValidationException;
use app\bundles\CoreBundle\Exception\RequestValidationException;
use app\bundles\CoreBundle\Exception\RequestValidatorException;
use app\bundles\CoreBundle\Interfaces\RequestValidatorInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class RequestValidator
 * @package App\CoreBundle\Validator
 */
class RequestValidator implements RequestValidatorInterface
{
    /**
     * @var FormFactoryInterface
     */
    protected FormFactoryInterface $formFactory;

    /**
     * @var RequestStack
     */
    protected RequestStack $requestStack;

    /**
     * RequestValidator constructor.
     * @param FormFactoryInterface $formFactory
     * @param RequestStack         $requestStack
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        RequestStack $requestStack
    ) {
        $this->formFactory  = $formFactory;
        $this->requestStack = $requestStack;
    }

    /**
     * @param string $formClass
     */
    public function validateForm(string $formClass): void
    {
        if ($this->getCurrentRequest()->getMethod() === 'GET') {
            return;
        }

        $form    = $this->formFactory->create($formClass);
        $request = $this->getCurrentRequest();

        switch ($request->headers->get('content-type')) {
            case 'application/x-www-form-urlencoded':
                $form->handleRequest($request);
                break;
            case 'application/json':
                $form->submit($request->request->all());
                break;
            default:
                throw new RequestValidationException('content.type.header.not.allowed');
        }

        if (!$form->isSubmitted() || !$form->isValid()) {
            throw new FormValidationException($form->getErrors(true));
        }
    }

    /**
     * @throws RequestValidatorException
     */
    private function getCurrentRequest(): Request
    {
        if (($request = $this->requestStack->getCurrentRequest()) === null) {
            throw new RequestValidatorException('request.not.present');
        }

        return $request;
    }
}
