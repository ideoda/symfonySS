<?php

namespace app\bundles\CoreBundle\Validator;

use app\bundles\CoreBundle\Exception\FormValidationException;
use app\bundles\CoreBundle\Exception\RequestValidationException;
use app\bundles\CoreBundle\Interfaces\RequestValidatorInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

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
     * RequestValidator constructor.
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory
    ) {
        $this->formFactory = $formFactory;
    }

    /**
     * @param Request $request
     * @param string  $formClass
     */
    public function validateForm(Request $request, string $formClass): void
    {
        $form = $this->formFactory->create($formClass);

        switch ($request->headers->get('content-type')) {
            case 'application/x-www-form-urlencoded':
                $form->handleRequest($request);
                break;
            case 'application/json':
                $form->submit($request->request->all());
                break;
            default:
                throw new RequestValidationException('Content-type header not allowed');
        }

        // TODO ezt majd ki kell innen vinni, a webpage validáció miatt
        if (!$form->isSubmitted() || !$form->isValid()) {
            $message = '';
            foreach ($form->getErrors() as $e) {
                $message .= sprintf(' %s %s', $e->getMessage(), implode('', $e->getMessageParameters()));
            }
            throw new FormValidationException($message);
        }
    }
}
