<?php

/*
 * This file is part of the IROrderBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\OrderBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Translation\TranslatorInterface;
use IR\Bundle\OrderBundle\IROrderEvents;

/**
 * Flash Listener.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class FlashListener implements EventSubscriberInterface
{
    private static $successMessages = array(               
        IROrderEvents::ORDER_CREATE_COMPLETED => 'ir_order.admin.order.flash.created',
        IROrderEvents::ORDER_EDIT_COMPLETED   => 'ir_order.admin.order.flash.updated',
        IROrderEvents::ORDER_DELETE_COMPLETED => 'ir_order.admin.order.flash.deleted',           
    );

    /**
     * @var SessionInterface
     */    
    protected $session;
    
    /**
     * @var TranslatorInterface
     */    
    protected $translator;

    
   /**
    * Constructor.
    *
    * @param SessionInterface    $session
    * @param TranslatorInterface $translator
    */            
    public function __construct(SessionInterface $session, TranslatorInterface $translator)
    {
        $this->session = $session;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */        
    public static function getSubscribedEvents()
    {
        return array(            
            IROrderEvents::ORDER_CREATE_COMPLETED => 'addSuccessFlash',
            IROrderEvents::ORDER_EDIT_COMPLETED   => 'addSuccessFlash',
            IROrderEvents::ORDER_DELETE_COMPLETED => 'addSuccessFlash',          
        );
    }

    /**
     * Adds a success flash message.
     * 
     * @param Event $event
     */            
    public function addSuccessFlash(Event $event)
    {
        if (!isset(self::$successMessages[$event->getName()])) {
            throw new \InvalidArgumentException('This event does not correspond to a known flash message');
        }

        $this->session->getFlashBag()->add('success', $this->translator->trans(self::$successMessages[$event->getName()]));
    }
}