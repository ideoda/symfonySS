<?php

namespace app\bundles\CoreBundle\ActionHandler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractApiActionHandler
 * @package app\bundles\CoreBundle\ActionHandler
 */
abstract class AbstractApiActionHandler extends AbstractActionHandler
{
    /**
     * @inheritDoc
     */
    protected function handleError(\Exception $e, Request $request): Response
    {
        return $this->responder->createJsonResponse(
            [
                'errorClass'   => \get_class($e),
                'errorMessage' => $e->getMessage(),
            ]
        );
    }

    /**
     * @inheritDoc
     */
    abstract protected function getAllowedRoles();

    /**
     * @inheritDoc
     */
    abstract protected function validate(Request $request): void;

    /**
     * @inheritDoc
     */
    protected function handle(Request $request): Response
    {
        // TODO: Implement handle() method.
    }
}
