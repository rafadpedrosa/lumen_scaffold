<?php

namespace rafadpedrosa\lumen_scaffold\config;

class Router extends \Laravel\Lumen\Routing\Router
{

    /**
     * Bootstrap the router instance.
     *
     * @return void
     */
    public function bootstrapRouter()
    {
        $this->router = new Router($this);
    }


    function resource($uri, $controller)
    {
        $this->get($uri . 's', $controller . '@listAll');
        $this->post($uri, $controller . '@store');
        $this->get($uri . '/{id}', $controller . '@show');
        $this->get($uri.'/{id}/edit', $controller.'@edit');
        $this->put($uri . '/{id}', $controller . '@update');
        $this->patch($uri . '/{id}', $controller . '@update');
        $this->delete($uri . '/{id}', $controller . '@destroy');
    }
}
