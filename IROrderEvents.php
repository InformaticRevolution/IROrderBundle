<?php

/*
 * This file is part of the IROrderBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\OrderBundle;

/**
 * Contains all events thrown in the IROrderBundle.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
final class IROrderEvents
{    
    /**
     * The ORDER_CREATE_COMPLETED event occurs after saving the order in the order creation process.
     *
     * The event listener method receives a IR\Bundle\OrderBundle\Event\OrderEvent instance.
     */
    const ORDER_CREATE_COMPLETED = 'ir_order.admin.order.create.completed';
    
    /**
     * The ORDER_EDIT_COMPLETED event occurs after saving the order in the order edit process.
     *
     * The event listener method receives a IR\Bundle\OrderBundle\Event\OrderEvent instance.
     */
    const ORDER_EDIT_COMPLETED = 'ir_order.admin.order.edit.completed';
    
    /**
     * The ORDER_DELETE_COMPLETED event occurs after deleting the order.
     *
     * The event listener method receives a IR\Bundle\OrderBundle\Event\OrderEvent instance.
     */
    const ORDER_DELETE_COMPLETED = 'ir_order.admin.order.delete.completed';
}