<?php

namespace app\bundles\CoreBundle\Descriptor;

use app\bundles\CoreBundle\Interfaces\DescriptorInterface;

/**
 * Class ErrorDescriptor
 * @package app\bundles\CoreBundle\Descriptor
 */
class ErrorDescriptor implements DescriptorInterface
{
    /**
     * @var \Exception
     */
    protected \Exception $error;

    /**
     * ErrorDescriptor constructor.
     * @param \Exception $e
     */
    public function __construct(\Exception $e)
    {
        $this->error = $e;
    }

    /**
     * @return mixed
     */
    public function getError(): \Exception
    {
        return $this->error;
    }

}
