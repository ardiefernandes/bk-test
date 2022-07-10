<?php

declare(strict_types=1);

use Framework\Exceptions\BadRequestException;
use Framework\Exceptions\MethodNotFoundException;
use Framework\Request;

/**
 * Register composer autoloader
 */
require __DIR__ . '/vendor/autoload.php';

/**
 * Sets exception handler
 */
set_exception_handler(function (\Exception $e)
{
    if ($e instanceof BadRequestException) {
        http_response_code(400);
        echo $e->getMessage();
    }

    if ($e instanceof MethodNotFoundException) {
        http_response_code(404);
    }
});

/**
 * Initialize and run application
 */
$app = new Framework\App();

/**
 * Initialize routes
 */
require_once __DIR__ . '/routes/routes.php';

$app->run(new Request());
