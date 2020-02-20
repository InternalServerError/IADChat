<?php
declare(strict_types=1);

namespace Foo\App\Controller;

use Foo\App\Model\UserModel as UserModel;

class User extends Controller
{
	/**
	 * Get users for periodic refresh
	 */
	public function getUsers(): void
	{
		$users = (new UserModel())->getConnectedUsers(true);

		echo json_encode($users);die;
	}
}
