<?php
declare(strict_types=1);

namespace Foo\App\Model;

use \PDO as PDO;
use App\Utils\Helper as Helper;
use Ramsey\Uuid\Uuid;

abstract class Model
{
	protected PDO $pdo;

	public function __construct()
	{
		$this->pdo = new PDO(getenv('MYSQL_DSN'), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'));
	}

	/**
	 * Generate unique uuid
	 *
	 * @return string
	 */
	protected function generateUuid(): string
	{
		return (Uuid::uuid4())->toString();
	}
}
