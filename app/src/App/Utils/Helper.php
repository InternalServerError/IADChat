<?php
declare(strict_types=1);

namespace Foo\Utils;

class Helper 
{
	/**
	 * Redirect to error page
	 */
	public static function redirectToErrorPage()
	{
		ob_start();
		header('Location: /page/error');
		ob_end_flush();
	}
}