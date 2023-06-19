<?php

namespace RBAC\App;

/**
 * Class Route
 */
class Route
{
    private $path;
    private $callable;
    private $matches = [];
    private $params = [];

    public function __construct($path, $callable)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }

    public static function getControllersNamespace(): string
    {
        return "RBAC\\Controllers\\";
    }

    public function url(): string
    {
        return $this->path;
    }

    public function match($url): bool
    {
        $parts = explode('/', $url);
        $path = explode(':', $this->path);

        if (count($parts) > 1) {
            if (count($parts) > 2 && trim($path[0], '/') === $parts[0].'/'.$parts[1]) {
                return true;
            }

            if (count($path) > 1 && trim($path[0], '/') === $parts[0]) {
                return true;
            }
        }

        return $this->path === $url;
    }

    public function matched($url): bool
    {
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path#i";

        if (! preg_match($regex, $url, $matches)) {
            return false;
        }
        if (count(explode('/', $url)) < 2) {
            return $this->path === $url;
        }

        array_shift($matches);
        $this->matches = $matches;

        return true;
    }

    public function paramMatch($match): string
    {
        if (isset($this->params[$match[1]])) {
            return '(' . $this->params[$match[1]] . ')';
        }

        return '([^/]+)';
    }

    public function getUrl($params): string
    {
        $path = $this->path;
        foreach ($params as $key => $value) {
            $path = str_replace(":$key", $value, $path);
        }

        return $path;
    }

    /**
     * @param mixed $data
     *
     * @return mixed
     */
    public function call($data = null)
    {
        if (is_string($this->callable)) {
            $params = explode('@', $this->callable);
            $controller = self::getControllersNamespace() . $params[0];
            $controller = new $controller();

            return call_user_func([$controller, $params[1]], $data);
        }

        return call_user_func_array($this->callable, $this->matches);
    }

    public function with($param, $regex): Route
    {
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this;
    }
}
