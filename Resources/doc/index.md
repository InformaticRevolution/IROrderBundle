Getting Started With IROrderBundle
==================================

## Prerequisites

This version of the bundle requires Symfony 2.1+.

## Installation

1. Download IROrderBundle using composer
2. Enable the Bundle
3. Create your classes
4. Configure the IROrderBundle
5. Import IROrderBundle routing
6. Update your database schema
7. Enable the doctrine extensions

### Step 1: Download IROrderBundle using composer

Add IROrderBundle in your composer.json:

``` js
{
    "require": {
        "informaticrevolution/order-bundle": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update informaticrevolution/order-bundle
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new IR\Bundle\OrderBundle\IROrderBundle(),
    );
}
```

### Step 3: Create your classes

**a) Create your Order class**

**Warning:**

> If you override the __construct() method in your Order class, be sure
> to call parent::__construct(), as the base Order class depends on
> this to initialize some fields.

##### Annotations

``` php
<?php
// src/Acme/OrderBundle/Entity/Order.php

namespace Acme\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\OrderBundle\Model\Order as BaseOrder;

/**
 * @ORM\Entity
 * @ORM\Table(name="acme_order")
 */
class Order extends BaseOrder
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="OrderItem", mappedBy="order", cascade={"all"}, orphanRemoval=true)
     */
    protected $items;


    /**
     * Constructor.
     */  
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```

##### Yaml or Xml

``` php
<?php
// src/Acme/OrderBundle/Entity/Order.php

namespace Acme\OrderBundle\Entity;

use IR\Bundle\OrderBundle\Model\Order as BaseOrder;

/**
 * Order implementation.
 */
class Order extends BaseOrder
{
    /**
     * Constructor.
     */  
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```

In YAML:

``` yaml
# src/Acme/OrderBundle/Resources/config/doctrine/Order.orm.yml
Acme\OrderBundle\Entity\Order:
    type:  entity
    table: acme_order
    id:
        id:
            type: integer
            generator:
                strategy: AUTO

    oneToMany:
        items:
            targetEntity: OrderItem
            mappedBy: order
            cascade: [ all ]
            orphanRemoval: true
```

In XML:

``` xml
<!-- src/Acme/OrderBundle/Resources/config/doctrine/Order.orm.xml -->
<?xml version="1.0" encoding="UTF-8"?>

<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="Acme\OrderBundle\Entity\Order" table="acme_order">
        <id name="id" type="integer" column="id">
            <generator strategy="AUTO" />
        </id> 

        <one-to-many field="items" target-entity="OrderItem" mapped-by="order" orphan-removal="true">
            <cascade>
                <cascade-all />
            </cascade>       
        </one-to-many>
    </entity>
    
</doctrine-mapping>
```

**b) Create your OrderItem class**

##### Annotations

``` php
<?php
// src/Acme/OrderBundle/Entity/OrderItem.php

namespace Acme\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\OrderBundle\Model\OrderItem as BaseOrderItem;

/**
 * @ORM\Entity
 * @ORM\Table(name="acme_order_item")
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
```

##### Yaml or Xml

``` php
<?php
// src/Acme/OrderBundle/Entity/OrderItem.php

namespace Acme\OrderBundle\Entity;

use IR\Bundle\OrderBundle\Model\OrderItem as BaseOrderItem;

/**
 * Order Item implementation.
 */
class OrderItem extends BaseOrderItem
{
}
```

In YAML:

``` yaml
# src/Acme/OrderBundle/Resources/config/doctrine/OrderItem.orm.yml
Acme\OrderBundle\Entity\OrderItem:
    type:  entity
    table: acme_order_item
    id:
        id:
            type: integer
            generator:
                strategy: AUTO
```

In XML:

``` xml
<!-- src/Acme/OrderBundle/Resources/config/doctrine/OrderItem.orm.xml -->
<?xml version="1.0" encoding="UTF-8"?>

<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="Acme\OrderBundle\Entity\OrderItem" table="acme_order_item">
        <id name="id" type="integer" column="id">
            <generator strategy="AUTO" />
        </id>
    </entity>
</doctrine-mapping>
```

### Step 4: Configure the IROrderBundle

Add the bundle minimum configuration to your `config.yml` file:

**a) Add the order configuration**

``` yaml
# app/config/config.yml
ir_order:
    db_driver: orm # orm is the only available driver for the moment 
    order_class: Acme\OrderBundle\Entity\Order
    order_item_class: Acme\OrderBundle\Entity\OrderItem
```

**b) Add the OrderInterface path to the RTEL**

``` yaml
# app/config/config.yml
doctrine:
    # ....
    orm:
        # ....
        resolve_target_entities:
            IR\Bundle\OrderBundle\Model\OrderInterface: Acme\OrderBundle\Entity\Order
```

### Step 5: Import IROrderBundle routing files

Add the following configuration to your `routing.yml` file:

``` yaml
# app/config/routing.yml
ir_order_admin:
    resource: "@IROrderBundle/Resources/config/routing.xml"
    prefix: /admin
```

### Step 6: Update your database schema

Run the following command:

``` bash
$ php app/console doctrine:schema:update --force
```

### Step 7: Enable the doctrine extensions

**a) Enable the stof doctrine extensions bundle in the kernel**

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
    );
}
```

**b) Enable the timestampable extension in your `config.yml` file**

``` yaml
# app/config/config.yml
stof_doctrine_extensions:
    orm:
        default:
            timestampable: true
```