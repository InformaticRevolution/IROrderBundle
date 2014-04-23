<?php

/*
 * This file is part of the IROrderBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\OrderBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use IR\Bundle\OrderBundle\Model\OrderInterface;

/**
 * Order Event.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OrderEvent extends Event
{
    /**
     * @var OrderInterface
     */        
    protected $order;
    
    
   /**
    * Constructor.
    *
    * @param OrderInterface $order
    */         
    public function __construct(OrderInterface $order)
    {
        $this->order = $order;
    }

    /**
     * Returns the order.
     * 
     * @return OrderInterface
     */
    public function getOrder()
    {
        return $this->order;
    }
}