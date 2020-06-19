<?php

namespace app\bundles\CoreBundle\Exception;

use Symfony\Component\Form\FormErrorIterator;
use Throwable;

/**
 * Class FormValidationException
 * @package app\bundles\CoreBundle\Exception
 */
class FormValidationException extends \Exception
{
    /**
     * @var FormErrorIterator
     */
    protected FormErrorIterator $formErrors;

    /**
     * FormValidationException constructor.
     * @param FormErrorIterator $formErrors
     * @param string            $message
     * @param int               $code
     * @param Throwable|null    $previous
     */
    public function __construct(FormErrorIterator $formErrors, $message = '', $code = 0, Throwable $previous = null)
    {
        foreach ($this->formErrors as $e) {
            $message .= sprintf(' %s %s', $e->getMessage(), implode('', $e->getMessageParameters()));
        }
        $this->message = $message;

        parent::__construct($message, $code, $previous);
        $this->formErrors = $formErrors;
    }

    /**
     * @return FormErrorIterator
     */
    public function getFormErrors(): FormErrorIterator
    {
        return $this->formErrors;
    }


}
