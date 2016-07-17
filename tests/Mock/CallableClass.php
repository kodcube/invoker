<?php
namespace KodCube\Invoker\Test\Mock;


class CallableClass
{
    public function __invoke() {
        return __CLASS__;
    }
}