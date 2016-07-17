<?php
namespace KodCube\Invoker\Test\Mock;


class StaticMethods
{
    public static function publicMethod() {
        return __METHOD__;
    }
    
    protected static function protectedMethod() {
        return __METHOD__;
    }
    
    private static function privateMethod() {
        return __METHOD__;
    }


    public static function withArguments(...$args)
    {
        return $args;
    }

}