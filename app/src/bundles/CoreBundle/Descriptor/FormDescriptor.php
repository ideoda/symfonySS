<?php

namespace app\bundles\CoreBundle\Descriptor;

use app\bundles\CoreBundle\Interfaces\DescriptorInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class FormDescriptor
 * @package app\bundles\CoreBundle\Descriptor
 */
class FormDescriptor implements DescriptorInterface
{
    /**
     * @var FormInterface
     */
    protected FormInterface $form;

    /**
     * @return FormInterface
     */
    public function getForm(): FormInterface
    {
        return $this->form;
    }

    /**
     * @param FormInterface $form
     */
    public function setForm(FormInterface $form): void
    {
        $this->form = $form;
    }
}
