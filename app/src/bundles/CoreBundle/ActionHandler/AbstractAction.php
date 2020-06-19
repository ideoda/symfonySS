<?php

namespace app\bundles\CoreBundle\ActionHandler;

use app\bundles\CoreBundle\Responder\Responder;
use app\bundles\CoreBundle\Validator\RequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractAction
 * @package app\bundles\CoreBundle\ActionHandler
 */
abstract class AbstractAction extends AbstractController
{
    /**
     * @var RequestValidator
     */
    protected RequestValidator $requestValidator;

    /**
     * @var Responder
     */
    protected Responder $responder;

    /**
     * PostLoginAction constructor.
     * @param RequestValidator $requestValidator
     * @param Responder        $responder
     */
    public function __construct(
        RequestValidator $requestValidator,
        Responder $responder
    ) {
        $this->requestValidator = $requestValidator;
        $this->responder        = $responder;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        try {

            if ($this->getAllowedRoles()) {
                $this->checkPermissions($this->getAllowedRoles());
            }

            $this->validateRequest($request);

            $response = $this->handle($request);
        }
        catch (\Exception $e) {
            $response = $this->handleError($e);
        }

        return $response;
    }

    /**
     * @param array $roleNames
     * @return void
     */
    protected function checkPermissions(array $roleNames): void
    {
        // TODO talán egy másik service lesz ez? permissionchecker service?
        // TODO user load, roles load, compare, throw exception
        if (empty($roleNames)) {
            return;
        }
    }

    /**
     * @return mixed
     */
    abstract protected function getAllowedRoles();

    /**
     * @param Request $request
     */
    abstract protected function validateRequest(Request $request): void;

    /**
     * @param Request $request
     * @return Response
     */
    abstract protected function handle(Request $request): Response;

    /**
     * @param \Exception $e
     * @return Response
     */
    abstract protected function handleError(\Exception $e): Response;
}
