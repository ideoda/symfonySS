<?php

namespace app\bundles\CoreBundle\ActionHandler;

use app\bundles\CoreBundle\Descriptor\ErrorDescriptor;
use app\bundles\CoreBundle\Interfaces\DescriptorInterface;
use app\bundles\CoreBundle\Responder\Responder;
use app\bundles\CoreBundle\Validator\RequestValidator;
use app\bundles\LoginBundle\Handler\LoginHandlerI;
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

            $descriptor = $this->handle($request);
        }
        catch (\Exception $e) {
            $descriptor = $this->handleError($e);
        }

        return $this->createResponse($descriptor);
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
     * @return DescriptorInterface
     */
    abstract protected function handle(Request $request): DescriptorInterface;

    /**
     * @param \Exception $e
     * @return ErrorDescriptor
     */
    abstract protected function handleError(\Exception $e): ErrorDescriptor;

    /**
     * @param DescriptorInterface $descriptor
     * @return Response
     */
    abstract protected function createResponse(DescriptorInterface $descriptor): Response;
}
