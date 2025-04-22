<?php
class Router {
    private $routes = [];
    private $params = [];

    public function add($route, $controller, $action) {
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z0-9-]+)', $route);
        $route = '/^' . $route . '$/i';
        $this->routes[$route] = [
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function match($url) {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function dispatch() {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        $url = strtok($url, '?');

        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $action = $this->params['action'];

            $controllerFile = APP_ROOT . '/controllers/' . $controller . '.php';
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $controllerClass = $controller;
                $controllerInstance = new $controllerClass();

                if (method_exists($controllerInstance, $action)) {
                    unset($this->params['controller'], $this->params['action']);
                    call_user_func_array([$controllerInstance, $action], $this->params);
                } else {
                    throw new Exception("Method $action not found in controller $controller");
                }
            } else {
                throw new Exception("Controller $controller not found");
            }
        } else {
            throw new Exception('No route matched.', 404);
        }
    }
} 