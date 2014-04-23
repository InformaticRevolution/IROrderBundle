<?php

/*
 * This file is part of the IROrderBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\OrderBundle\Tests\Controller\Admin;

use IR\Bundle\OrderBundle\Tests\Functional\WebTestCase;

/**
 * Order Controller Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OrderControllerTest extends WebTestCase
{
    const FORM_INTENTION = 'order';
    
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->loadFixtures('order');
    }     
    
    public function testListAction()
    {
        $crawler = $this->client->request('GET', '/admin/orders/');

        $this->assertResponseStatusCode(200);
        $this->assertCount(3, $crawler->filter('table tbody tr'));
    }    
    
    public function testShowAction()
    {
        $this->client->request('GET', '/admin/orders/1');
        
        $this->assertResponseStatusCode(200);
    }    
    
    public function testNewActionGetMethod()
    {
        $crawler = $this->client->request('GET', '/admin/orders/new');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));
    }   
    
    public function testNewActionPostMethod()
    {        
        $this->client->request('POST', '/admin/orders/new', array(
            'ir_order_form' => array (
                'items' => array(
                    0 => array(
                        'quantity'  => $this->faker->randomDigitNotNull(),
                        'unitPrice' => $this->faker->randomFloat(2,1),
                    ),
                ),
                '_token' => $this->generateCsrfToken(self::FORM_INTENTION),
            ) 
        ));  
        
        $this->assertResponseStatusCode(302);
        
        $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/admin/orders/4');
    }      
    
    public function testEditActionGetMethod()
    {   
        $crawler = $this->client->request('GET', '/admin/orders/1/edit');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));        
    }         
    
    public function testEditActionPostMethod()
    {        
        $this->client->request('POST', '/admin/orders/1/edit', array(
            'ir_order_form' => array (
                'items' => array(
                    0 => array(
                        'quantity'  => $this->faker->randomDigitNotNull(),
                        'unitPrice' => $this->faker->randomFloat(2,1),
                    ),
                ),                
                '_token' => $this->generateCsrfToken(self::FORM_INTENTION),
            ) 
        ));     
        
        $this->assertResponseStatusCode(302);
        
        $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/admin/orders/1');
    }    
    
    public function testDeleteAction()
    {
        $this->client->request('GET', '/admin/orders/1/delete');
        
        $this->assertResponseStatusCode(302);
        
        $crawler = $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/admin/orders/');
        $this->assertCount(2, $crawler->filter('table tbody tr'));
    }      
    
    public function testNotFoundHttpWhenOrderNotExist()
    {
        $this->client->request('GET', '/admin/orders/foo');
        $this->assertResponseStatusCode(404);        
        
        $this->client->request('GET', '/admin/orders/foo/edit');
        $this->assertResponseStatusCode(404);

        $this->client->request('GET', '/admin/orders/foo/delete');
        $this->assertResponseStatusCode(404);      
    }      
}
