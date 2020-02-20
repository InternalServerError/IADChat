<?php
declare(strict_types=1);

namespace Foo\App\Controller;

use Foo\Core\Request as Request;
use \PDO as PDO;

abstract class Controller
{
	protected Request $request;
	protected PDO $pdo;
	protected $user;

	public function __construct(array $requestContainer)
	{
		$this->request = $requestContainer['request'];
		$this->pdo = new PDO($this->request->getEnv('MYSQL_DSN'), $this->request->getEnv('MYSQL_USER'), $this->request->getEnv('MYSQL_PASSWORD'));
		$this->user = $_SESSION['LoggedUser'] ? unserialize($_SESSION['LoggedUser']): null;
	}
}
