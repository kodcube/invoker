<?php
namespace KodCube\Invoker;

use KodCube\Helpers\Arrays;
use ReflectionMethod;
use Exception;
use Throwable;

/**
 * Calls an invoked class::method with passed params
 * 
 * @author Steven Miles <steve@srmiles.com>
 */

class Invoker implements InvokerInterface
{
    /**
     * @inheritdoc
     */
    
    public function invoke(string $className, array $methodParams=null, array $classParams=null)
    {
        return $this($className,$methodParams,$classParams);
    }

    /**
     * Class Invoker
     *
     * @param string $className
     * @param array|NULL $methodParams
     * @param array|NULL $classParams
     * @return mixed
     * @throws \Exception
     */
    public function __invoke(string $className, array $methodParams=null, array $classParams=null)
    {

        $className  = str_replace('.','\\',$className);
        $methodName = null;
        
        if (strpos($className,'::') !== false) {

            list($className,$methodName) = explode('::',$className);

        }
        
        // Check if the Class Exists
        
        if ( ! class_exists($className,true) ) throw new MissingClassException($className.' does not exist');
        
        
        if ( ! is_null($methodName)) {
            
            // Check if Static Method or Object Method Call
            try {
                $reflectionMethod = new \ReflectionMethod($className, $methodName);
            } catch (Throwable $t) {
                throw new MissingMethodException($className.'::'.$methodName.' does not exist');
            }

            if ($reflectionMethod->isStatic()) {

                return $this->staticMethodCall($className,$methodName,$methodParams);
            }

            
            // Create Instance of Class
            
            return $this->objectMethodCall($className,$classParams,$methodName,$methodParams);
        }

        // If there are no method must be a invokable object
      
        // Create Instance of Class
        $class = $this->createObject($className,$classParams);

        if ( ! is_callable($class) ) {
            throw new NotCallableException($className.' is not callable');
        }
        
        return $this->objectCall($class,$methodParams);

    }

    public function staticMethodCall($className,$methodName,$methodParams=null) 
    {

        $reflection = new ReflectionMethod($className,$methodName);

        if ($reflection->isProtected() ) {
            throw new ProtectedMethodException($className.'::'.$methodName.' is Protected');
        }

        if ($reflection->isPrivate() ) {
            throw new PrivateMethodException($className.'::'.$methodName.' is Private');
        }

       // Static Method Call
        if ( is_array($methodParams) && ! Arrays::isAssoc($methodParams) ) {

            // Invoke Static Method with multiple arguments
            return $className::$methodName(...$methodParams);

        }
        
        // Invoke Static Method with single argument 
        return $className::$methodName($methodParams);

    }
    
    public function objectMethodCall($className,$classParams=null,$methodName,$methodParams=null)
    {
        $class = $this->createObject($className,$classParams);
    
        if ( ! method_exists($class,$methodName) ) {
            throw new \Exception($className.'::'.$methodName.' not found');
        }
  
        if ( ! is_callable($className.'::'.$methodName) ) {

            throw new ProtectedMethodException($className.'::'.$methodName.' is not Callable');

        }

        // Invoke Object Method with multiple arguments
        if ( is_array($methodParams) && ! Arrays::isAssoc($methodParams) ) {

            return $class->$methodName(...$methodParams);

        }

        // Invoke Object Method with single argument
        return $class->$methodName($methodParams);
    }
    
    public function objectCall($class,$methodParams=null)
    {
        // Invoke Object Method with multiple arguments
        if ( is_array($methodParams) && ! Arrays::isAssoc($methodParams) ) {

            return $class(...$methodParams);

        }

        // Invoke Object Method with single argument
        return $class($methodParams);
    }

    public function createObject($className,$classParams=null)
    {
        $class = new \ReflectionClass($className);
        
        if ( $class->getConstructor() === null ) {

            return new $className;

        }
        
        if ( $classParams === null || empty($classParams)) {
            
            return new $className();
            
        }
        
        if ( is_array($classParams) && ! Arrays::isAssoc($classParams) ) {
            
            // Invoke Object with multiple arguments
            return new $className(...$classParams);

        }

        // Invoke Object with single argument
        return new $className($classParams);
    }

}