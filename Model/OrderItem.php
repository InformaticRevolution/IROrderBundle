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
 * Abstract Order Item implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class OrderItem implements OrderItemInterface
{
    /**
     * Item id.
     * 
     * @var mixed
     */
    protected $id;
    
    /**
     * Order.
     * 
     * @var OrderInterface
     */
    protected $order;
    
    /**
     * Quantity.
     * 
     * @var integer
     */
    protected $quantity = 1;
    
    /**
     * Unit price.
     * 
     * @var float
     */
    protected $unitPrice;
    
    
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return $this->order;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setOrder(OrderInterface $order = null)  
    {
        $this->order = $order;
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setUnitPrice($unitPrice)  
    {
        $this->unitPrice = $unitPrice;
        
        return $this;
    }
}
