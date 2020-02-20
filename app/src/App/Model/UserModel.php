<?php
declare(strict_types=1);

namespace Foo\App\Model;

use Foo\App\Entity\UserEntity as UserEntity;
use Foo\Core\Router as Router;

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
			Router::renderErrorPage();
		}

		$users = array_map(function($rawUser) use ($toArray) {
			$user = (new UserEntity())->setId($rawUser['user_id'])
						->setNickname($rawUser['nickname'])
						->setPassword($rawUser['password']);

			return $toArray ? $user->toArray() : $user;
		}, $rawUsers);

		return $users;
	}

	/**
	 * Get user by nickname and password
	 *
	 * @param array $data
	 *
	 * @return UserEntity
	 * @throws \Exception
	 */
	public function getUser(array $data): ?UserEntity
	{
		try {
			$sqlQuery = "SELECT u.id AS user_id, u.nickname AS nickname, u.password AS password "
							. "FROM users u "
							. "WHERE nickname = :nickname";

			$stmt = $this->pdo->prepare($sqlQuery);
			$stmt->execute([':nickname' => $data['login-nickname']]);
			$rawUser = $stmt->fetch(\PDO::FETCH_ASSOC);
		} catch(\Throwable $t) {
			Router::renderErrorPage();
		}

		if (!$rawUser) {
			$user = (new UserEntity())->setId($this->generateUuid())
						->setNickname($data['login-nickname'])
						->setPassword($data['login-password'], true);

			$this->insertUser($user);

			return $user;
		}

		if (password_verify($data['login-password'], $rawUser['password'])) {
			$user = (new UserEntity())->setId($rawUser['user_id'])
						->setNickname($rawUser['nickname'])
						->setPassword($rawUser['password']);
			$this->createUserSession($user);

			return $user;
		} else {
			throw new \Exception('Ce nom d\'utilisateur existe déjà !');
		}
	}

	/**
	 * Create new user and new user session
	 *
	 * @param UserEntity $user
	 */
	private function insertUser(UserEntity $user): void
	{
		try {
			$sqlQuery = "INSERT INTO users VALUES(:id, :nickname, :password)";

			$stmt = $this->pdo->prepare($sqlQuery);
			$stmt->execute([
				':id' => $user->getId(), 
				':nickname' => $user->getNickname(),
				':password' => $user->getPassword(),
			]);
		} catch(\Throwable $t) {
			Router::renderErrorPage();
		}
		$this->createUserSession($user);
	}

	/**
	 * Create User session
	 */
	private function createUserSession(UserEntity $user): void
	{
		try {
			$sqlQuery = "INSERT INTO users_sessions VALUES(:id, :user_id, CURRENT_TIMESTAMP())";
			$stmt = $this->pdo->prepare($sqlQuery);
			$stmt->execute([
				':id' => $this->generateUuid(),
				':user_id' => $user->getId(),
			]);
		} catch (\Throwable $t) {
			Router::renderErrorPage();
		}
	}

	/**
	 * Clear session for logout
	 *
	 * @param UserEntity $user
	 */
	public function clearSessions(UserEntity $user): void
	{
		try {
			$sqlQuery = "DELETE FROM users_sessions WHERE user_id = :user_id";
			$stmt = $this->pdo->prepare($sqlQuery);
			$stmt->execute([':user_id' => $user->getId()]);
		} catch (\Throwable $t) {
			Router::renderErrorPage();
		}
	}
}
