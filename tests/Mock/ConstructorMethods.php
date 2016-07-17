<?php
namespace KodCube\Invoker\Test\Mock;

use KodCube\Invoker\Test\Mock\DependencyClass;

class ConstructorMethods
{
    public function __construct(DependencyClass $dependency,...$arguments)
    {
        $this->dependency = $dependency;
        $this->arguments = $arguments;
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
        return $this->arguments;
    }


    public function withArguments(...$args)
    {
        return $args;
    }
}