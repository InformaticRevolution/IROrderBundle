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
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Abstract Order implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class Order implements OrderInterface
{
    /**
     * Order id.
     * 
     * @var mixed
     */
    protected $id;
    
    /**
     * Invoice number.
     * 
     * @var string
     */
    protected $invoiceNumber;
    
    /**
     * Items.
     * 
     * @var Collection
     */
    protected $items;

    /**
     * Creation time.
     * 
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * Last update time.
     * 
     * @var \DateTime
     */
    protected $updatedAt;     
    
    
    /**
     * Constructor.
     */
    public function __construct() 
    {
        $this->items = new ArrayCollection();
    }
    
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
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setInvoiceNumber($invoiceNumber)  
    {
        $this->invoiceNumber = $invoiceNumber;
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getItems()
    {
        return $this->items;
    }
    
    /**
     * {@inheritdoc}
     */
    public function addItem(OrderItemInterface $item)
    {
        if (!$this->hasItem($item)) {
            $item->setOrder($this);
            $this->items->add($item);
        }
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeItem(OrderItemInterface $item)
    {
        if ($this->items->removeElement($item)) {
            $item->setOrder(null);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasItem(OrderItemInterface $item)
    {
        return $this->items->contains($item);
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt) 
    {
        $this->createdAt = $createdAt;
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt = null)
    {
        $this->updatedAt = $updatedAt;
        
        return $this;
    }
}
