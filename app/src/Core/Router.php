<?php
declare(strict_types=1);

namespace Foo\Core;

use Foo\Core\Request as Request;

class Router {
	/**
	 * Parse request for routing
	 *
	 * @param string $url
	 * @param Request $request
	 */
    public function parseRequest(string $url, Request $request): void
    {
    	$isAuthorized = $_SESSION['loggedIn'] ? true : false;
    	$url = trim($url);
    	if (preg_grep('/^\/login$/', [$url])) {
    		if (!$isAuthorized) {
    			$this->fillRequestParameters($request, $url);
			} else {
				$this->fillRequestParameters($request);
				static::redirectTo();
			}
    	} else {
    		if ($isAuthorized) {
				$this->fillRequestParameters($request, $url);
    		} else {
    			if (!$isAuthorized && preg_grep('/^\/login\//', [$url])) {
					$this->fillRequestParameters($request, $url);
    			} else {
					$this->fillRequestParameters($request, '/login');
					static::redirectTo('/login');
				}
    		}
		}
    }

    /**
     * Hydrate request object with right parameters
     *
     * @param $string url
     */
    private function fillRequestParameters(Request &$request, string $url = '/'): void
    {
    	switch ($url) {
    		case '/':
    		case '/home':
			    $request->controller = 'Home';
			    $request->action = 'index';
			    $request->params = [];
			    break;
		    case '/login':
				$request->controller = 'Login';
				$request->action = 'index';
				$request->params = [];
				break;
			default:
			    $urlExploded = array_slice(explode('/', $url), 1);
			    $request->controller = ucfirst($urlExploded[0]);
	    	    $request->action = $urlExploded[1];
		    	$request->params = array_slice($urlExploded, 2);
		    	break;
    	}
    }

	/**
	 * Redirect to error page
	 */
    public static function renderErrorPage()
    {
		ob_start();
		header('Location: /page/error');
		ob_end_flush();
    }

	/**
	 * Redirect to given URL
	 *
	 * @param string $url
	 */
	public static function redirectTo(string $url = '/')
	{
		ob_start();
		header('Location: ' . $url);
		ob_end_flush();
	}
}

