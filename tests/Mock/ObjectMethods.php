<?php
namespace KodCube\Invoker\Test\Mock;


class ObjectMethods
{
    public function __construct(...$args)
    {
        $this->constructorArguments = $args;
    }


    public function publicMethod() {
        return __METHOD__;
    }
    
    protected function protectedMethod() {
        return __METHOD__;
    }
    
    private function privateMethod() {
        return __METHOD__;
    }

    public function withConstructorArguments()
    {
        return $this->constructorArguments;
    }


    public function withArguments(...$args)
    {
        return $args;
    }
}