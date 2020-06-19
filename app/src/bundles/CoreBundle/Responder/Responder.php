<?php

namespace app\bundles\CoreBundle\Responder;

use app\bundles\CoreBundle\Descriptor\ErrorDescriptor;
use app\bundles\CoreBundle\Interfaces\DescriptorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\Error;

/**
 * Class Responder
 * @package app\bundles\CoreBundle\Responder
 */
class Responder
{
    /**
     * @var Environment
     */
    protected Environment $twig;

    /**
     * Responder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param string $templateName
     * @param array  $templateData
     * @return Response
     */
    public function createTwigResponse(string $templateName, array $templateData = []): Response
    {
        try {
            $content = $this->twig->render($templateName, $templateData);
        }
        catch (Error $e) {
            return new Response($e->getMessage());
        }

        return new Response($content);
    }

    /**
     * @param \Exception $e
     * @return Response
     */
    public function createTwigErrorResponse(\Exception $e): Response
    {
        return $this->createTwigResponse('@Error/error.html.twig', ['error' => $e->getMessage()]);
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function createJsonResponse(array $data): JsonResponse
    {
        return new JsonResponse($data);
    }

    // TODO respondert szétkapni? webappresponder és apiresponder? akkor viszont az abstractactionhandler-t is szét kell szedni, alábontani ketté és azokba külön injektálni a respondert. kell ez? így most átláthatóbb a kód, ade úgy meg joban szét van kapva
}
