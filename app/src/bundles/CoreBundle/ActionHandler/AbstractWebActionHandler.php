<?php

namespace app\bundles\CoreBundle\ActionHandler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractWebActionHandler
 * @package app\bundles\CoreBundle\ActionHandler
 */
abstract class AbstractWebActionHandler extends AbstractActionHandler
{
    /**
     * @inheritDoc
     */
    protected function handleError(\Exception $e, Request $request): Response
    {
        return new Response($e->getMessage());
    }
}
