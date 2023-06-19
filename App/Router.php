<?php

namespace RBAC\App;

/**
 * Class Router
 */
class Router
{

    private $routes = [];
    private $url;
    private $namedRoutes = [];

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function get($path, $callable, $name = null)
    {
        return $this->addRoute($path, $callable, $name, 'GET');
    }

    public function post($path, $callable, $name = null)
    {
        return $this->addRoute($path, $callable, $name, 'POST');

    }

    /**
     * @param $path
     * @param $callable
     * @param $name
     * @param $method
     * @return Route
     */
    public function addRoute($path, $callable, $name, $method)
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if (is_string($callable) && $name === null) {
            $name = $callable;
        }
        if ($name) {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
	}

    public function listRoute()
    {
        foreach ($this->routes['GET'] as $route) {
            echo "<pre>";
            print_r($route);
            echo "</pre>";
        }
	}

    public function run()
    {
        if (! isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new RouterException("REQUEST_METHOD not found");
        }
        $data = null;
        $parts = explode('/', $this->url);

        if (isset($parts[1])) {
            $data = $parts[1];

//            if ((isset($parts[2]) && $parts[1] !== 'delete') || (!isset($parts[2]) && empty($parts[2]) && $parts[1] === 'delete')) {
//                return call_user_func([new (Route::getControllersNamespace() . 'Controller'), 'callErrorPage']);
//            }

            if (isset($parts[2]) && !empty($parts[2])) {
                $data = $parts[2];
            }
        }

        /** @var Route $route */
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url)) {
                return $route->call($data);
            }
        }

        return call_user_func([new (Route::getControllersNamespace() . 'Controller'), 'callErrorPage']);
    }

    public function url($name, $params = [])
    {
        if (!isset($this->namedRoutes[$name])) {
            throw new RouterException("No route matches this name");
        }

        return $this->namedRoutes[$name]->getUrl($params);
    }
}
