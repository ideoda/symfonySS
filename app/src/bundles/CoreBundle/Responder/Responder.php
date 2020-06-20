<?php

namespace app\bundles\CoreBundle\Responder;

use app\bundles\CoreBundle\Descriptor\ErrorDescriptor;
use app\bundles\CoreBundle\Interfaces\DescriptorInterface;
use Symfony\Component\Form\Form;
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
            foreach ($templateData as $k => $v) {
                if ($v instanceof Form) {
                    $templateData['form'] = $v->createView();
                    unset($templateData[$k]);
                }
            }

            $content = $this->twig->render($templateName, $templateData);
        }
        catch (Error $e) {
            return new Response($e->getMessage());
        }

        return new Response($content);
    }

    /**
     * @param string     $templateName
     * @param \Exception $e
     * @return Response
     */
    public function createTwigErrorPageResponse(string $templateName, \Exception $e): Response
    {
        return $this->createTwigResponse($templateName, ['error' => $e->getMessage()]);
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function createJsonResponse(array $data): JsonResponse
    {
        return new JsonResponse($data);
    }

    /**
     * @param \Exception $e
     * @return JsonResponse
     */
    public function createJsonErrorResponse(\Exception $e): JsonResponse
    {
        return new JsonResponse(
            [
                'errorClass'   => \get_class($e),
                'errorMessage' => $e->getMessage(),
                'errorTrace'   => str_replace('#', str_repeat(' ', 160).'#', $e->getTraceAsString()),
            ]);
    }
}
