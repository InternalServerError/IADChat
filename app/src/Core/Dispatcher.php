<?php
declare(strict_types=1);

namespace Foo\Core;

use Foo\App\Controller\Controller as Controller;

class Dispatcher 
{
    private $request;

    /**
     * Dispatch request to router
     */
    public function dispatch(): void
    {
		$this->request = new Request();
		$router = new Router();
		$router->parseRequest($this->request->getUrl(), $this->request);
		try {
		  $controller = $this->loadController();
		} catch (\Throwable $t) { 
            Router::renderErrorPage();
        }
		$handler = [$controller, strtolower($this->request->getMethod()).ucfirst($this->request->action)];
		if (!is_callable($handler)) {
			Router::renderErrorPage();
		}
		call_user_func_array($handler, [$this->request]);
    }

    /**
     * Load controller to execute action
     *
     * @return Controller
     */
    public function loadController(): Controller
    {
		$controllerName = 'Foo\App\Controller\\'.$this->request->controller;
		
		return new $controllerName($this->request->toArray());
    }
}
