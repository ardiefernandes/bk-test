<?php

declare(strict_types=1);

namespace Framework\Exceptions;

class MethodNotFoundException extends \Exception
{
    /**
     * Instance constructor
     *
     * @param string|null $message
     */
    public function __construct(?string $message = null)
    {
        parent::__construct($message ?? 'Not Found');
    }
}
