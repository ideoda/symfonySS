<?php

namespace app\bundles\CoreBundle\RouteLoader;

use app\bundles\CoreBundle\Exception\RouteLoaderException;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class CoreRouteLoader
 * @package app\bundles\CoreBundle\RouteLoader
 */
class CoreRouteLoader extends Loader
{
    // TODO a foldereket sokkal szebbre kell csinálni (kernelRootDir?)

    /**
     * @var array
     */
    protected array $acceptedMethods;

    /**
     * CoreRouteLoader constructor.
     * @param array $acceptedMethods
     */
    public function __construct(array $acceptedMethods)
    {
        $this->acceptedMethods = $acceptedMethods;
    }

    /**
     * @param mixed       $resource
     * @param string|null $type
     * @return RouteCollection
     * @throws RouteLoaderException
     */
    public function load($resource, string $type = null): RouteCollection
    {
        return $this->createRouteCollectionFromFiles($this->findActionFiles());
    }

    /**
     * @inheritDoc
     */
    public function supports($resource, string $type = null)
    {
        return $type === 'coreRouteLoader';
    }

    /**
     * @inheritDoc
     */
    public function getResolver()
    {
        // TODO: Implement getResolver() method.
    }

    /**
     * @inheritDoc
     */
    public function setResolver(LoaderResolverInterface $resolver)
    {
        // TODO: Implement setResolver() method.
    }

    /**
     * @param SplFileInfo $file
     * @return string|null
     */
    protected function getMethodFromFile(SplFileInfo $file): ?string
    {
        foreach ($this->acceptedMethods as $method) {
            if (preg_match("/^$method/i", $file->getFilename())) {
                return $method;
            }
        }
        throw new RouteLoaderException('HTTP method not valid');
    }

    /**
     * @param SplFileInfo $file
     * @return string
     */
    protected function getPathFromFile(SplFileInfo $file): string
    {
        // TODO ide majd még be kell a parameteres routingot is tenni pl users/32

        $pathname        = $file->getPathname();
        $folderStructure = preg_replace('/^.*actions\/(.*)\/.*.php$/', '$1', $pathname);
        $folderStructure = explode('/', $folderStructure);

        $filenameString = preg_replace('/^.*\/(Get|Post|Put|Delete|Patch)(.*)\.php$/', '$2', $pathname);

        // TODO GetLoginId legyen értelmes route
        $filenameStringArray = explode(' ', preg_replace("([A-Z])", " $0", $filenameString));

        // TODO GetLoginId legyen értelmes route

        if (strtolower(end($folderStructure)) === strtolower($filenameString)) {
            array_pop($folderStructure);
        }

        $path = '/';
        foreach ($folderStructure as $folder) {
            $path .= $folder.'/';
        }
        $path .= strtolower($filenameString);

        return $path;
    }

    /**
     * @param SplFileInfo $file
     * @return string
     */
    protected function getControllerNameFromFile(SplFileInfo $file): string
    {
        $string = str_replace(['/', '.php'], ['\\', ''], $file->getRelativePathname());

        return 'app\\actions\\'.$string;
    }

    /**
     * @param SplFileInfo $file
     * @return string
     */
    protected function getRouteNameFromFile(SplFileInfo $file): string
    {
        $pathname = $file->getPathname();
        $string   = preg_replace('/^.*actions\/(.*).php$/', '$1', $pathname);

        return strtolower(implode('_', explode('/', $string)));
    }

    /**
     *
     */
    protected function findActionFiles(): Finder
    {
        $finder = new Finder();

        $finder->files()->in(__DIR__.'/../../../actions/')->name('*.php');

        if ($finder->hasResults() === false) {
            throw new RouteLoaderException('No routes found. Checked all "Action" folders in src/*/Actions/*');
        }

        return $finder;
    }

    /**
     * @param Finder $files
     * @return RouteCollection
     */
    protected function createRouteCollectionFromFiles(Finder $files): RouteCollection
    {
        $routes = new RouteCollection();

        foreach ($files as $file) {
            $route = new Route(
                $this->getPathFromFile($file),
                [
                    '_controller' => $this->getControllerNameFromFile($file),
                ],
                [],
                [],
                null,
                null,
                $this->getMethodFromFile($file),
                null
            );

            $routes->add(
                $this->getRouteNameFromFile($file),
                $route
            );
        }

        return $routes;
    }
}
