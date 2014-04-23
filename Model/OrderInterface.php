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

use Doctrine\Common\Collections\Collection;

/**
 * Order Interface.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface OrderInterface 
{
    /**
     * Returns the id.
     * 
     * @return mixed
     */
    public function getId(); 
    
    /**
     * Returns the invoice number.
     * 
     * @return string
     */
    public function getInvoiceNumber();
    
    /**
     * Sets the invoice number.
     * 
     * @param string $invoiceNumber.
     * 
     * @return self
     */
    public function setInvoiceNumber($invoiceNumber);

    /**
     * Returns all the items.
     *
     * @return Collection
     */
    public function getItems(); 
    
    /**
     * Adds an item.
     *
     * @param OrderItemInterface $item
     * 
     * @return self
     */
    public function addItem(OrderItemInterface $item);
    
    /**
     * Removes an item.
     *
     * @param OrderItemInterface $item
     * 
     * @return self
     */
    public function removeItem(OrderItemInterface $item);    
    
    /**
     * Checks whether order has given item.
     *
     * @param OrderItemInterface $item
     *
     * @return Boolean
     */
    public function hasItem(OrderItemInterface $item); 

    /**
     * Returns the creation time.
     *
     * @return \DateTime
     */
    public function getCreatedAt();   
    
    /**
     * Sets the creation time.
     * 
     * @param \DateTime $createdAt
     * 
     * @return self
     */
    public function setCreatedAt(\DateTime $createdAt);    
    
    /**
     * Returns the last update time.
     *
     * @return \DateTime
     */
    public function getUpdatedAt();  
    
    /**
     * Sets the last update time.
     * 
     * @param \DateTime|null $updatedAt
     * 
     * @return self
     */
    public function setUpdatedAt(\DateTime $updatedAt = null);     
}
