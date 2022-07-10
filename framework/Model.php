<?php

declare(strict_types=1);

namespace Framework;

class Model
{
    /**
     * Data
     *
     * @var object
     */
    protected $data;

    /**
     * Instance constructor
     */
    public function __construct()
    {
        $this->data = require_once __DIR__ . '/../resources/data.php';
    }
}
