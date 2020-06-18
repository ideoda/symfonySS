<?php

namespace app\bundles\CoreBundle\Responder;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

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
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function createTwigResponse(string $templateName, array $templateData = []): Response
    {
        $content = $this->twig->render($templateName, $templateData);

        return new Response($content);
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function createJsonResponse($data): JsonResponse
    {
        return new JsonResponse($data);
    }

    // TODO respondert szétkapni? webappresponder és apiresponder? akkor viszont az abstractactionhandler-t is szét kell szedni, alábontani ketté és azokba külön injektálni a respondert. kell ez? így most átláthatóbb a kód, ade úgy meg joban szét van kapva
}
