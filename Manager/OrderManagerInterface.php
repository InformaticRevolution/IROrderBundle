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

use IR\Bundle\OrderBundle\Model\OrderInterface;

/**
 * Order Manager Interface.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface OrderManagerInterface 
{
    /**
     * Creates an empty order instance.
     *
     * @return OrderInterface
     */
    public function createOrder();    

    /**
     * Updates an order.
     *
     * @param OrderInterface $order
     */
    public function updateOrder(OrderInterface $order);    

    /**
     * Deletes an order.
     *
     * @param OrderInterface $order
     */
    public function deleteOrder(OrderInterface $order);       
    
    /**
     * Finds an order by the given criteria.
     *
     * @param array $criteria
     *
     * @return OrderInterface|null
     */
    public function findOrderBy(array $criteria);      
    
    /**
     * Finds orders by given criteria.
     * 
     * @param array        $criteria
     * @param array|null   $orderBy
     * @param integer|null $limite
     * @param integer|null $offset
     * 
     * @return array
     */
    public function findOrdersBy(array $criteria, array $orderBy = null, $limite = null, $offset = null);      
    
    /**
     * Returns the order's fully qualified class name.
     *
     * @return string
     */
    public function getClass();    
}
