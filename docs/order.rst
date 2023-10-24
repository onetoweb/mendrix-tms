.. _top:
.. title:: Orders

`Back to index <index.rst>`_

======
Orders
======

.. contents::
    :local:


Get Order Ids
`````````````

.. code-block:: php
    
    $result = $client->getOrderIds([
        'nested' => false,
        'filter' => [
            'period_begin' => (new DateTime())->setDate(2023, 1, 1),
            'period_end' => (new DateTime())->setDate(2023, 8, 1),
            'client_no' => 1889,
            'operator_id' => -1,
        ]
    ]);


Get Orders by Ids
`````````````````

.. code-block:: php
    
    $result = $client->getOrders([
        'nested' => false,
        'ids' => [120, 121, 122, 123, 124]
    ]);


Create Order
````````````

.. code-block:: php
    
    $result = $client->createOrder([
        'id' => -1000,
        'client_id' => 1889,
        'contact' => 'Hr. Kwartel',
        'moment' => (new DateTime())->setDate(2018, 3, 13)->setTime(16, 0, 0),
        'product_id' => 1,
        'product_id_automatic_articles' => true,
        'goods' => [
            [
                'id' => -1,
                'barcode' => 'MXG00000087',
                'comments' => 'Hout',
                'depth' => 0.0,
                'height' => 0.0,
                'packing_type' => 'Doos',
                'parts' => 12.0,
                'volume' => 0.0,
                'volume_weight' => 0.0,
                'article_weight' => 0.0,
                'weight' => 15.0,
                'width' => 0.0
            ], [
                'id' => -2,
                'barcode' => 'MXG00000088',
                'comments' => 'Spijkers',
                'depth' => 0.0,
                'height' => 0.0,
                'packing_type' => 'Envelop',
                'parts' => 1.0,
                'volume' => 0.0,
                'volume_weight' => 0.0,
                'article_weight' => 0.0,
                'weight' => 5.0,
                'width' => 0.0
            ]
        ],
        'tasks' => [
            [
                'id' => -100,
                'address' => [
                    'name' => 'Intratuin',
                    'premise' => 'Piet',
                    'street' => 'Intratuinweg 12',
                    'number' => '',
                    'postal_code' => '1000 BB',
                    'place' => 'Amsterdam',
                    'state' => '',
                    'country' => 'Nederland',
                    'country_code' => 'NL'
                ],
                'cash_on_delivery' => 0.0,
                'connectivity' => [
                    'email' => '',
                    'fax' => '',
                    'mobile' => '',
                    'phone' => '0413-556623',
                    'web' => '',
                ],
                'contact_name' => '',
                'instructions' => 'Trek werkschoenen aan!',
                'operator_id_automatic' => true,
                'operator_id_subautomatic' => true,
                'reference_our' => '',
                'reference_your' => 'UWKENM567',
                'requested' => [
                    'date_time_end' => (new DateTime())->setDate(2018, 3, 14)->setTime(10, 0, 0),
                    'date_time_begin' => (new DateTime())->setDate(2018, 3, 14)->setTime(15, 0, 0)
                ],
                'task_type_id' => 1
            ], [
                'id' => -200,
                'address' => [
                    'name' => 'Sjaak de Vries',
                    'premise' => 'Kwartel',
                    'street' => 'De Jonghstraat 4',
                    'number' => '',
                    'postal_code' => '5461 HD',
                    'place' => 'Veghel',
                    'state' => '',
                    'country' => 'Nederland',
                    'country_code' => 'NL'
                ],
                'cash_on_delivery' => 0.0,
                'connectivity' => [
                    'email' => '',
                    'fax' => '',
                    'mobile' => '',
                    'phone' => '0413-556623',
                    'web' => '',
                ],
                'contact_name' => '',
                'instructions' => 'Let op! Grote hond aanwezig',
                'operator_id_automatic' => true,
                'operator_id_subautomatic' => true,
                'reference_our' => '',
                'reference_your' => 'UWKENM567',
                'requested' => [
                    'date_time_end' => (new DateTime())->setDate(2018, 3, 15)->setTime(18, 0, 0),
                    'date_time_begin' => (new DateTime())->setDate(2018, 3, 15)->setTime(7, 0, 0)
                ],
                'task_type_id' => 2
            ]
        ],
        'goods_to_tasks' => [
            [
                'good_id' => -1,
                'task_id' => -100
            ], [
                'good_id' => -1,
                'task_id' => -200
            ], [
                'good_id' => -2,
                'task_id' => -100
            ], [
                'good_id' => -2,
                'task_id' => -200
            ]
        ],
        'external_done' => true,
        'external_source' => 7
    ]);


`Back to top <#top>`_