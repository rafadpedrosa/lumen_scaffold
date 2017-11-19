<?php

namespace rafadpedrosa\lumen_scaffold;

class Application extends \Laravel\Lumen\Application
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
}
