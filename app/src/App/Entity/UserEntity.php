<?php
declare(strict_types=1);

namespace Foo\App\Entity;

class UserEntity
{
	private string $id;
	private string $nickname;
	private string $password;

	/**
	 * Retrieve id of user Entity
	 *
	 * @return null|string
	 */
	public function getId(): ?string
	{
		return $this->id;
	}

	/**
	 * Retrieve nickname of user Entity
	 *
	 * @return null|string
	 */
	public function getNickname(): ?string
	{
		return $this->nickname;
	}

	/**
	 * Retrieve hashed password of user Entity
	 *
	 * @return null|string
	 */
	public function getPassword(): ?string
	{
		return $this->password;
	}
	/**
	 * Set id of user Entity
	 *
	 * @param string $id
	 *
	 * @return self
	 */
	public function setId(string $id): self
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * Set nickname of user Entity
	 *
	 * @param string $nickname
	 *
	 * @return self
	 */
	public function setNickname(string $nickname): self
	{
		$this->nickname = $nickname;

		return $this;
	}

	/**
	 * Set password of user Entity
	 *
	 * @param string $password
	 * @param bool $hash -- Optional, default to false
	 *
	 * @return self
	 */
	public function setPassword(string $password, $hash = false): self
	{
		if ($hash) {
			$password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
		}
		$this->password = $password;

		return $this;
	}

	/**
	 * Get user as array for JSON output
	 *
	 * @return array
	 */
	public function toArray(): array
	{
		return [
			'id' => $this->getId(),
			'nickname' => $this->getNickname(),
		];
	}
}
