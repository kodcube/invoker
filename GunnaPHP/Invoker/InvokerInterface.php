<?php
namespace KodCube\Invoker;



interface InvokerInterface 
{
    
    public function __invoke(string $className, array $methodParams=null, array $classParams=null);

}