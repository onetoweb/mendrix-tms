.. title:: Index

===========
Basic Usage
===========

Setup
        
.. code-block:: php
    
    require 'vendor/autoload.php';
    
    use Onetoweb\MendrixTms\Client;
    
    // param1
    $baseUrl = 'http://{ip}:{port}';
    $username = '{username}';
    $password = '{password}';
    
    // setup client
    $client = new Client($baseUrl, $username, $password);


========
Examples
========

* `DateTime <date_time.rst>`_
* `Orders <order.rst>`_
