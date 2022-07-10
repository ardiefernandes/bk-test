<?php

declare(strict_types=1);

namespace Framework;

class Routes
{
    /**
     * Singleton instance
     *
     * @var self
     */
    private static $instance;

    /**
     * Routes collection
     *
     * @var RoutesCollection
     */
    private $routes;

    /**
     * Instance constructor
     */
    private function __construct()
    {
        $this->routes = new RoutesCollection();
    }

    /**
     * Returns routes handler singleton instance
     *
     * @return self
     */
    public static function instance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Adds route through GET method
     *
     * @param string $uri
     * @param mixed  $handler
     *
     * @return self
     */
    public function get(string $uri, $handler): self
    {
        return $this->addRoute('GET', $uri, $handler);
    }

    /**
     * Retrieves handler for the given request
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function getHandler(Request $request)
    {
        return $this->routes->find($request->method, $request->uri);
    }

    /**
     * Adds route
     *
     * @param string $method
     * @param string $uri
     * @param mixed $handler
     *
     * @return self
     */
    private function addRoute(string $method, string $uri, $handler): self
    {
        $this->routes->push($method, $uri, $handler);

        return $this;
    }
}
