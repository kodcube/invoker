<?php
namespace KodCube\Invoker;

use KodCube\Helpers\Arrays;
use Interop\Container\ContainerInterface;
use ReflectionClass;

class ContainerInvoker extends Invoker implements InvokerInterface
{
    protected $container = null;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function createObject($className,$classParams=null)
    {
        $class = new ReflectionClass($className);

        if ( $class->getConstructor() === null ) {

            return new $className;

        }

        if ( $classParams === null || empty($classParams)) {

            return $this->container->get($className);

        }

        if ( is_array($classParams) && ! Arrays::isAssoc($classParams) ) {

            // Invoke Object with multiple arguments
            return $this->container->get($className,...$classParams);

        }

        // Invoke Object with single argument
        return $this->container->get($className,$classParams);
    }

}