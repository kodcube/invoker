<?php
namespace KodCube\Invoke\Test\UnitTest;

use KodCube\DependencyInjection\Container;
use KodCube\Invoker\ContainerInvoker AS Invoker;
use KodCube\Invoker\NotCallableException;
use KodCube\Invoker\ProtectedMethodException;
use KodCube\Invoker\PrivateMethodException;
use KodCube\Invoker\MissingClassException;
use KodCube\Invoker\MissingMethodException;
use KodCube\Invoker\Test\Mock\CallableClass;
use KodCube\Invoker\Test\Mock\ConstructorMethods;
use KodCube\Invoker\Test\Mock\NotCallableClass;
use KodCube\Invoker\Test\Mock\StaticMethods;
use TypeError;

/**
 * Class ContainerInvokerTest
 * @package KodCube\Invoke\Test\UnitTest
 *
 * Object::__invoke
 * Object::method
 * Class::staticMethod
 *
 */


class ContainerInvokerTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->container = new Container();
    }


    /**
     * Check Alias to Class Map
     */
    public function testConstructor()
    {
        $invoker = new Invoker($this->container);
        $this->assertTrue(true);
    }

    public function testMissingContainer()
    {
        $this->setExpectedException(TypeError::class);
        $invoker = new Invoker();

    }


    /**
     * Test public __invoke method
     */
    public function testMissingClass()
    {
        $this->setExpectedException(MissingClassException::class);

        $invoker = new Invoker($this->container);
        $invoker('MyMissingClass');

    }


    /**
     * Test public __invoke method
     */
    public function testMissingMethod()
    {
        $this->setExpectedException(MissingMethodException::class);

        $invoker = new Invoker($this->container);
        $invoker(ConstructorMethods::class.'::missingMethod');

    }


    /**
     * Test public __invoke method
     */
    public function testCallableClassNoDependenciesNoArguments()
    {
        $invoker = new Invoker($this->container);

        $result = $invoker(CallableClass::class);

        $this->assertEquals($result,CallableClass::class);
    }

    /**
     * Test Object with no __invoke method
     */
    public function testNotCallableClassNoDependenciesNoArguments()
    {
        $this->setExpectedException(NotCallableException::class);
        
        $invoker = new Invoker($this->container);

        $invoker(NotCallableClass::class);

    }


    /**
     * Test protected customMethod method
     */
    public function testPublicObjectMethod()
    {
        $invoker = new Invoker($this->container);
        $className = ConstructorMethods::class.'::publicMethod';

        $result = $invoker($className);

        $this->assertEquals($result,$className);
    }

    /**
     * Tests calling private ObjectMethods::protectedMethod method
     */
    public function testProtectedObjectMethod()
    {

        $this->setExpectedException(ProtectedMethodException::class);

        $invoker = new Invoker($this->container);
        $className = ConstructorMethods::class.'::protectedMethod';
        $invoker($className);

    }

    /**
     * Tests calling private ObjectMethods::privateMethod method
     */
    public function testPrivateObjectMethod()
    {

        $this->setExpectedException(ProtectedMethodException::class);

        $invoker = new Invoker($this->container);
        $className = ConstructorMethods::class.'::privateMethod';

        $invoker($className);

    }


    /**
     * Test protected customMethod method
     */
    public function testPublicStaticMethod()
    {
        $invoker = new Invoker($this->container);
        $className = StaticMethods::class.'::publicMethod';

        $result = $invoker($className);

        $this->assertEquals($result,$className);
    }

    /**
     * Tests calling private ObjectMethods::protectedMethod method
     */
    public function testProtectedStaticMethod()
    {

        $this->setExpectedException(ProtectedMethodException::class);

        $invoker = new Invoker($this->container);
        $className = StaticMethods::class.'::protectedMethod';
        $invoker($className);

    }

    /**
     * Tests calling private ObjectMethods::privateMethod method
     */
    public function testPrivateStaticMethod()
    {

        $this->setExpectedException(PrivateMethodException::class);

        $invoker = new Invoker($this->container);
        $className = StaticMethods::class.'::privateMethod';

        $invoker($className);

    }


    /**
     * Tests calling private ObjectMethods::withArguments method
     */
    public function testObjectMethodWithArguments()
    {
        $invoker = new Invoker($this->container);

        $className = ConstructorMethods::class.'::withArguments';
        $methodArguments = ['argument1','argument2','argument3'];

        $result = $invoker($className,$methodArguments);

        $this->assertEquals($methodArguments,$result);
    }

    /**
     * Tests calling private StaticMethods::withArguments method
     */
    public function testStaticMethodWithArguments()
    {
        $invoker = new Invoker($this->container);

        $className = StaticMethods::class.'::withArguments';
        $methodArguments = ['argument1','argument2','argument3'];

        $result = $invoker($className,$methodArguments);

        $this->assertEquals($methodArguments,$result);
    }

    /**
     * Tests calling private ObjectConstructorMethods::withContructorArguments method
     */
    public function testObjectMethodWithConstuctorArguments()
    {
        $invoker = new Invoker($this->container);

        $className = ConstructorMethods::class.'::withConstructorArguments';

        $constructorArguments = [null,'argument1','argument2','argument3'];

        $result = $invoker($className,null,$constructorArguments);
        array_shift($constructorArguments);
        $this->assertEquals($constructorArguments,$result);
    }


}
