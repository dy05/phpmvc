<?php

namespace RBAC\App;

/**
 * Class Router
 */
class Router
{
    private $url;
    private $routes = [];
    private $namedRoutes = [];

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function get($path, $callable, $name = null): Route
    {
        return $this->addRoute($path, $callable, $name);
    }

    public function post($path, $callable, $name = null): Route
    {
        return $this->addRoute($path, $callable, $name, 'POST');
    }

    public function put($path, $callable, $name = null): Route
    {
        return $this->addRoute($path, $callable, $name, 'PUT');
    }

    public function patch($path, $callable, $name = null): Route
    {
        return $this->addRoute($path, $callable, $name, 'PATCH');
    }

    public function delete($path, $callable, $name = null): Route
    {
        return $this->addRoute($path, $callable, $name, 'DELETE');
    }

    /**
     * @param $path
     * @param $callable
     * @param string|null $name
     * @param string $method
     *
     * @return Route
     */
    public function addRoute($path, $callable, string $name = null, string $method = 'GET'): Route
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

    /**
     * @throws RouterException
     */
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

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'POST' && in_array($_POST['_method'], ['PUT', 'PATCH', 'DELETE'])) {
            $method = $_POST['_method'];
        }

        /**
         * @var Route $route
         */
        foreach ($this->routes[$method] as $route) {
            if ($route->match($this->url)) {
                return $route->call($data);
            }
        }

        return call_user_func([new (Route::getControllersNamespace() . 'PagesController'), 'callErrorPage']);
    }

    /**
     * @throws RouterException
     */
    public function url($name, $params = [])
    {
        if (! isset($this->namedRoutes[$name])) {
            throw new RouterException("No route matches this name");
        }

        return $this->namedRoutes[$name]->getUrl($params);
    }
}
