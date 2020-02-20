<?php
declare(strict_types=1);

namespace Foo\App\Controller;

use Foo\Core\View as View;

class Page extends Controller 
{
	/**
	 * Display generic error page
	 */
	public function getError(): void
	{
		$view = new View('error');
	}
}
