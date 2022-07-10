<?php

declare(strict_types=1);

namespace Framework;

use Framework\Exceptions\MethodNotFoundException;

class RoutesCollection
{
    /**
     * Routes collection
     *
     * @var array
     */
    private $routes = [];

    /**
     * Pushes route into the collection
     *
     * @param string $method
     * @param string $uri
     * @param mixed  $handler
     *
     * @return void
     */
    public function push(string $method, string $uri, $handler): void
    {
        if (!array_key_exists($method, $this->routes)) {
            $this->routes[$method] = [];
        }

        $this->routes[$method][$uri] = $handler;
    }

    /**
     * Returns handler for given request method and uri
     *
     * @param string $method
     * @param string $uri
     *
     * @return void
     */
    public function find(string $method, string $uri)
    {
        if (
            !array_key_exists($method, $this->routes) ||
            !array_key_exists($uri, $this->routes[$method])
        ) {
            throw new MethodNotFoundException();
        }

        return $this->routes[$method][$uri];
    }
}
