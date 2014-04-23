<?php

/*
 * This file is part of the IROrderBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\OrderBundle\Manager;

/**
 * Abstract Order Manager.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class OrderManager implements OrderManagerInterface
{
    /**
     * {@inheritDoc}
     */    
    public function createOrder()
    {
        $class = $this->getClass();

        return new $class();
    }      
}
