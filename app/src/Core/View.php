<?php
declare(strict_types=1);

namespace Foo\Core;

class View
{
	private array $data = [];
	private $render = false;

	public function __construct(string $template)
	{
        $file = __DIR__ . '/../templates/' . strtolower($template) . '.php';

        if (file_exists($file)) {
            $this->render = $file;
        }
	}

	/**
	 * Assign data for view rendering
	 *
	 * @param mixed $variable
	 * @param mixed $value
	 */
	public function assign($variable, $value): void
	{
	    $this->data[$variable] = $value;
	}

	/**
	 * Destruct the view instance
	 */
	public function __destruct()
	{
	    extract($this->data);
	    include($this->render);
	}
}
