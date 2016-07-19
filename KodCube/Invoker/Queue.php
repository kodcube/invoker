<?php
namespace KodCube\Invoker;

use GunnaPHP\Queue\ProviderInterface AS QueueInterface;

/**
 * Queues an invoked class::method to a background process instead of executing 
 * within the current process
 *
 * @author Steven Miles <steve@srmiles.com>
 */

class Queue implements InvokerInterface
{
    protected $queue = null;
    
    /**
     * @param QueueInterface $queue Queue Provider Interface
     */
    
    public function __construct(QueueInterface $queue)
    {
        $this->queue = $queue;
    }

    /**
     * @inheritdoc
     */

    public function __invoke(string $className, array $methodParams=null, array $classParams = null)
    {
        
        return $this->queue->enqueue([
            'className'    => $className,
            'methodParams' => $methodParams,
            'classParams'  => $classParams
        ]);

    }
}