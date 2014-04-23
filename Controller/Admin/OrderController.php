<?php

/*
 * This file is part of the IROrderBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\OrderBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use IR\Bundle\OrderBundle\IROrderEvents;
use IR\Bundle\OrderBundle\Event\OrderEvent;
use IR\Bundle\OrderBundle\Model\OrderInterface;

/**
 * Admin controller managing the orders.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OrderController extends ContainerAware
{
    /**
     * List all the orders.
     */
    public function listAction()
    {
        $orders = $this->container->get('ir_order.manager.order')->findOrdersBy(array(), array('createdAt' => 'desc'));

        return $this->container->get('templating')->renderResponse('IROrderBundle:Admin/Order:list.html.'.$this->getEngine(), array(
            'orders' => $orders,
        ));
    }    
    
    /**
     * Show order details.
     */
    public function showAction($id)
    {
        $order = $this->findOrderById($id);

        return $this->container->get('templating')->renderResponse('IROrderBundle:Admin/Order:show.html.'.$this->getEngine(), array(
            'order' => $order
        ));
    }       
    
    /**
     * Create a new order: show the new form.
     */
    public function newAction(Request $request)
    {       
        /* @var $orderManager \IR\Bundle\OrderBundle\Manager\OrderManagerInterface */
        $orderManager = $this->container->get('ir_order.manager.order');
        $order = $orderManager->createOrder();
        
        $form = $this->container->get('ir_order.form.order'); 
        $form->setData($order);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $orderManager->updateOrder($order);
            
            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');                      
            $dispatcher->dispatch(IROrderEvents::ORDER_CREATE_COMPLETED, new OrderEvent($order));
                
            return new RedirectResponse($this->container->get('router')->generate('ir_order_admin_order_show', array('id' => $order->getId())));                      
        }
        
        return $this->container->get('templating')->renderResponse('IROrderBundle:Admin/Order:new.html.'.$this->getEngine(), array(
            'order' => $order,
            'form'  => $form->createView(),
        ));          
    }    
    
    /**
     * Edit an order: show the edit form.
     */
    public function editAction(Request $request, $id)
    {
        $order = $this->findOrderById($id);

        $form = $this->container->get('ir_order.form.order');      
        $form->setData($order);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $this->container->get('ir_order.manager.order')->updateOrder($order);
            
            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');               
            $dispatcher->dispatch(IROrderEvents::ORDER_EDIT_COMPLETED, new OrderEvent($order));
                
            return new RedirectResponse($this->container->get('router')->generate('ir_order_admin_order_show', array('id' => $order->getId())));                     
        }        
        
        return $this->container->get('templating')->renderResponse('IROrderBundle:Admin/Order:edit.html.'.$this->getEngine(), array(
            'order' => $order,
            'form'  => $form->createView(),
        ));          
    }      
    
    /**
     * Delete an order.
     */
    public function deleteAction($id)
    {
        $order = $this->findOrderById($id);
        $this->container->get('ir_order.manager.order')->deleteOrder($order);
        
        /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');          
        $dispatcher->dispatch(IROrderEvents::ORDER_DELETE_COMPLETED, new OrderEvent($order));
        
        return new RedirectResponse($this->container->get('router')->generate('ir_order_admin_order_list'));   
    }      
    
    /**
     * Finds an order by id.
     *
     * @param mixed $id
     *
     * @return OrderInterface
     * 
     * @throws NotFoundHttpException When order does not exist
     */
    protected function findOrderById($id)
    {
        $order = $this->container->get('ir_order.manager.order')->findOrderBy(array('id' => $id));

        if (null === $order) {
            throw new NotFoundHttpException(sprintf('The order with id %s does not exist', $id));
        }

        return $order;
    }        
    
    /**
     * Returns the template engine.
     * 
     * @return string
     */    
    protected function getEngine()
    {
        return $this->container->getParameter('ir_order.template.engine');
    }       
}
