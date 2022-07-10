<?php

declare(strict_types=1);

namespace Framework;

use Framework\Exceptions\MethodNotFoundException;

class Router
{
    /**
     * Singleton instance
     *
     * @var self
     */
    private static $instance;

    /**
     * Routes instance
     *
     * @var Routes
     */
    private $routes;

    /**
     * Instance constructor
     */
    private function __construct()
    {
        $this->routes = Routes::instance();
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
     * Dispatches request
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function dispatch(Request $request)
    {
        $handler = $this->routes->getHandler($request);

        if (is_callable($handler)) {
            return $handler($request);
        }

        $matches = [];

        if (
            is_string($handler) &&
            preg_match('/(.*)@(.*)/', $handler, $matches)
        ) {
            if (!class_exists($matches[1])) {
                throw new MethodNotFoundException();
            }

            $controller = new $matches[1]();

            if (!method_exists($controller, $matches[2])) {
                throw new MethodNotFoundException();
            }

            return $controller->{$matches[2]}($request);
        }
    }
}
