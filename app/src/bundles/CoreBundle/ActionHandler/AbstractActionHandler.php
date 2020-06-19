<?php

namespace app\bundles\CoreBundle\ActionHandler;

use app\bundles\CoreBundle\Responder\Responder;
use app\bundles\CoreBundle\Validator\RequestValidator;
use app\bundles\LoginBundle\Handler\Login;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractActionHandler
 * @package app\bundles\CoreBundle\ActionHandler
 */
abstract class AbstractActionHandler extends AbstractController
{
    /**
     * @var RequestValidator
     */
    protected RequestValidator $requestValidator;

    /**
     * @var Login
     */
    protected Login $loginHandler;

    /**
     * @var Responder
     */
    protected Responder $responder;

    /**
     * PostLoginAction constructor.
     * @param RequestValidator $requestValidator
     * @param Login            $loginHandler
     * @param Responder        $responder
     */
    public function __construct(
        RequestValidator $requestValidator,
        Login $loginHandler,
        Responder $responder
    ) {
        $this->requestValidator = $requestValidator;
        $this->loginHandler     = $loginHandler;
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
            $response = $this->handleError($e, $request);
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
        if (empty($roleNames)) {
            return;
        }
        //TODO user load, roles load, compare, throw exception
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
     * @param Request    $request
     * @return Response
     */
    abstract protected function handleError(\Exception $e, Request $request): Response;
}
