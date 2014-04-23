<?php

/*
 * This file is part of the IROrderBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\OrderBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

use IR\Bundle\OrderBundle\Model\OrderInterface;
use IR\Bundle\OrderBundle\Manager\OrderManager as AbstractOrderManager;

/**
 * Doctrine Order Manager.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OrderManager extends AbstractOrderManager
{
    /**
     * @var ObjectRepository
     */          
    protected $objectManager;
    
    /**
     * @var ObjectRepository
     */           
    protected $repository;    

    /**
     * @var string
     */           
    protected $class;  
    
    
   /**
    * Constructor.
    *
    * @param ObjectManager $om
    * @param string        $class
    */        
    public function __construct(ObjectManager $om, $class)
    {                   
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);
        
        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();       
    }    

    /**
     * Updates an order.
     *
     * @param OrderInterface $order
     * @param Boolean        $andFlush Whether to flush the changes (default true)
     */    
    public function updateOrder(OrderInterface $order, $andFlush = true)
    { 
        $this->objectManager->persist($order);
   
        if ($andFlush) {
            $this->objectManager->flush();
        }        
    }    

    /**
     * {@inheritDoc}
     */     
    public function deleteOrder(OrderInterface $order)
    {
        $this->objectManager->remove($order);
        $this->objectManager->flush();      
    }         
    
    /**
     * {@inheritDoc}
     */
    public function findOrderBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }         
    
    /**
     * {@inheritdoc}
     */    
    public function findOrdersBy(array $criteria, array $orderBy = null, $limite = null, $offset = null) 
    {
        return $this->repository->findBy($criteria, $orderBy, $limite, $offset);
    }     
    
    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }    
}
