<?php

declare(strict_types=1);

namespace Framework;

class App
{
    /**
     * Router handler instance
     *
     * @var Router
     */
    private $router;

    /**
     * Instance constructor
     */
    public function __construct()
    {
        $this->router = Router::instance();
    }

    /**
     * Handles request through the router
     *
     * @param Request $request
     *
     * @return void
     */
    public function run(Request $request): void
    {
        echo $this->router->dispatch($request);
    }
}
