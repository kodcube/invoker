<?php
namespace KodCube\Invoke\Test\UnitTest;

use KodCube\Invoker\Invoker;
use KodCube\Invoker\NotCallableException;
use KodCube\Invoker\ProtectedMethodException;
use KodCube\Invoker\PrivateMethodException;
use KodCube\Invoker\MissingClassException;
use KodCube\Invoker\MissingMethodException;
use KodCube\Invoker\Test\Mock\CallableClass;
use KodCube\Invoker\Test\Mock\NotCallableClass;
use KodCube\Invoker\Test\Mock\ProtectedCallableClass;
use KodCube\Invoker\Test\Mock\ObjectMethods;
use KodCube\Invoker\Test\Mock\StaticMethods;
use Exception;
use Error;

/**
 * Class InvokerTest
 * @package KodCube\Invoke\Test\UnitTest
 *
 * Object::__invoke
 * Object::method
 * Class::staticMethod
 *
 */


class InvokerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Check Alias to Class Map
     */
    public function testConstructor()
    {
        $invoker = new Invoker();
        $this->assertTrue(true);
    }

    /**
     * Test public __invoke method
     */
    public function testMissingClass()
    {
        $this->setExpectedException(MissingClassException::class);

        $invoker = new Invoker();
        $invoker('MyMissingClass');

    }


    /**
     * Test public __invoke method
     */
    public function testMissingMethod()
    {
        $this->setExpectedException(MissingMethodException::class);

        $invoker = new Invoker();
        $invoker(ObjectMethods::class.'::missingMethod');

    }


    /**
     * Test public __invoke method
     */
    public function testCallableClassNoDependenciesNoArguments()
    {
        $invoker = new Invoker();

        $result = $invoker(CallableClass::class);

        $this->assertEquals($result,CallableClass::class);
    }

    /**
     * Test Object with no __invoke method
     */
    public function testNotCallableClassNoDependenciesNoArguments()
    {
        $this->setExpectedException(NotCallableException::class);
        
        $invoker = new Invoker();

        $invoker(NotCallableClass::class);

    }


    /**
     * Test protected customMethod method
     */
    public function testPublicObjectMethod()
    {

        //$this->setExpectedException(Exception::class);

        $invoker = new Invoker();
        $className = ObjectMethods::class.'::publicMethod';

        $result = $invoker($className);

        $this->assertEquals($result,$className);
    }

    /**
     * Tests calling private ObjectMethods::protectedMethod method
     */
    public function testProtectedObjectMethod()
    {

        $this->setExpectedException(ProtectedMethodException::class);

        $invoker = new Invoker();
        $className = ObjectMethods::class.'::protectedMethod';
        $invoker($className);

    }

    /**
     * Tests calling private ObjectMethods::privateMethod method
     */
    public function testPrivateObjectMethod()
    {

        $this->setExpectedException(ProtectedMethodException::class);

        $invoker = new Invoker();
        $className = ObjectMethods::class.'::privateMethod';

        $invoker($className);

    }


    /**
     * Test protected customMethod method
     */
    public function testPublicStaticMethod()
    {
        $invoker = new Invoker();
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

        $invoker = new Invoker();
        $className = StaticMethods::class.'::protectedMethod';
        $invoker($className);

    }

    /**
     * Tests calling private ObjectMethods::privateMethod method
     */
    public function testPrivateStaticMethod()
    {

        $this->setExpectedException(PrivateMethodException::class);

        $invoker = new Invoker();
        $className = StaticMethods::class.'::privateMethod';

        $invoker($className);

    }


    /**
     * Tests calling private ObjectMethods::withArguments method
     */
    public function testObjectMethodWithArguments()
    {
        $invoker = new Invoker();

        $className = ObjectMethods::class.'::withArguments';
        $methodArguments = ['argument1','argument2','argument3'];

        $result = $invoker($className,$methodArguments);

        $this->assertEquals($methodArguments,$result);
    }

    /**
     * Tests calling private StaticMethods::withArguments method
     */
    public function testStaticMethodWithArguments()
    {
        $invoker = new Invoker();

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
        $invoker = new Invoker();

        $className = ObjectMethods::class.'::withConstructorArguments';

        $constructorArguments = ['argument1','argument2','argument3'];

        $result = $invoker($className,null,$constructorArguments);

        $this->assertEquals($constructorArguments,$result);
    }


}
