<?php

namespace app\bundles\CoreBundle\Listener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * Class JsonDeserializeListener
 * @package app\bundles\CoreBundle\Listener
 */
class JsonRequestDeserializeListener
{
    /**
     * @param RequestEvent $event
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (strncmp($request->headers->get('Content-Type'), 'application/json', 16) === 0) {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
            $request->request->replace(\is_array($data) ? $data : []);
        }

    }
}
