<?php

/*
 * This file is part of the IROrderBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\OrderBundle\Model;

/**
 * Order Item Interface.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface OrderItemInterface 
{
    /**
     * Returns the id.
     * 
     * @return mixed
     */
    public function getId();
    
    /**
     * Returns the order.
     * 
     * @return OrderInterface
     */
    public function getOrder();
    
    /**
     * Sets the order.
     * 
     * @param OrderInterface|null $order
     * 
     * @return self
     */
    public function setOrder(OrderInterface $order = null);
    
    /**
     * Returns the quantity.
     *
     * @return integer
     */
    public function getQuantity();

    /**
     * Sets the quantity.
     *
     * @param integer $quantity
     * 
     * @return self
     */
    public function setQuantity($quantity); 
    
    /**
     * Returns the unit price.
     *
     * @return float
     */
    public function getUnitPrice();

    /**
     * Sets the unit price.
     *
     * @param float $unitPrice
     * 
     * @return self
     */
    public function setUnitPrice($unitPrice);  
}
