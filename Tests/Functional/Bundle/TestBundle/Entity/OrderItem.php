<?php

/*
 * This file is part of the IROrderBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\OrderBundle\Tests\Functional\Bundle\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\OrderBundle\Model\OrderItem as BaseOrderItem;

/**
 * @ORM\Entity
 * @ORM\Table(name="item")
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OrderItem extends BaseOrderItem
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id; 
}
