<?php

declare(strict_types=1);

use Framework\Routes;

$route = Routes::instance();

$route->get('/', function ()
{
    return 'Backend Test Application';
});

$route->get('/best-supplier', '\\App\\Controllers\\Supplier@getBestSupplier');
