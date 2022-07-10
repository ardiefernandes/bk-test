<?php

declare(strict_types=1);

namespace Framework;

class Request
{
    /**
     * Request method
     *
     * @var string
     */
    public $method;

    /**
     * Request uri
     *
     * @var string
     */
    public $uri;

    /**
     * Request params
     *
     * @var array
     */
    private $params = [];

    /**
     * Instance constructor
     */
    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri    = preg_replace('/(.*)(\?.*)/', '$1', $_SERVER['REQUEST_URI']);
        $this->params = $_REQUEST;
    }

    /**
     * Returns request param
     *
     * @param string|null $key
     *
     * @return mixed
     */
    public function input(?string $key = null)
    {
        if (isset($key)) {
            return $this->params[$key] ?? null;
        }

        return $this->params;
    }
}
