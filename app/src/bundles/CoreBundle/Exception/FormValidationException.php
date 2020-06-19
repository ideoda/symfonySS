<?php

namespace app\bundles\CoreBundle\Exception;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormErrorIterator;
use Throwable;

/**
 * Class FormValidationException
 * @package app\bundles\CoreBundle\Exception
 */
class FormValidationException extends \Exception
{
    /**
     * @var Form
     */
    protected Form $form;

    /**
     * FormValidationException constructor.
     * @param Form           $form
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(Form $form, $message = '', $code = 0, Throwable $previous = null)
    {
        $this->form = $form;

        $formErrors = $form->getErrors(true);
        foreach ($formErrors as $e) {
            $message .= sprintf(' %s %s', $e->getMessage(), implode('', $e->getMessageParameters()));
        }
        $this->message = $message;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return Form
     */
    public function getForm(): Form
    {
        return $this->form;
    }

    /**
     * @return FormErrorIterator
     */
    public function getFormErrors(): FormErrorIterator
    {
        return $this->form->getErrors(true);
    }


}
