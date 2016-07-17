<?php
namespace KodCube\Invoker\Test\Mock;


class ProtectedCallableClass
{
    public function __invoke() {
        return __CLASS__;
    }
}