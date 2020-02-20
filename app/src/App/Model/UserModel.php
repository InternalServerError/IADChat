<?php
declare(strict_types=1);

namespace Foo\App\Model;

use Foo\App\Entity\UserEntity as UserEntity;

class UserModel extends Model
{
	/**
	 * Get connected users
	 *
	 * @return array
	 */
	public function getConnectedUsers(bool $toArray = false): array
	{
		try {
			$sqlQuery = "SELECT u.id AS user_id, u.nickname AS nickname, u.password AS password "
						. "FROM users u "
						. "INNER JOIN users_sessions us "
							. "ON u.id = us.user_id "
						. "ORDER BY u.nickname ASC";
			$stmt = $this->pdo->prepare($sqlQuery);
			$stmt->execute();
			$rawUsers = $stmt->fetchAll();
		} catch (\Throwable $t) {
			Helper::redirectToErrorPage();
		}

		$users = array_map(function($rawUser) use ($toArray) {
			$user = (new UserEntity())->setId($rawUser['user_id'])
						->setNickname($rawUser['nickname'])
						->setPassword($rawUser['password']);

			return $toArray ? $user->toArray() : $user;
		}, $rawUsers);

		return $users;
	}
}
