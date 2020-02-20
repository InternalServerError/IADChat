<?php
declare(strict_types=1);

namespace Foo\App\Entity;

class MessageEntity
{
	private string $id;
	private string $author;
	private string $text;
	private string $postedAt;

	public function __construct()
	{
		$this->postedAt = (new \DateTime())->format('d/m/y H:i:s');
	}

	/**
	 * Retrieve id of message Entity
	 *
	 * @return null|string
	 */
	public function getId(): ?string
	{
		return $this->id;
	}

	/**
	 * Retrieve author of message Entity
	 *
	 * @return null|string
	 */
	public function getAuthor(): ?string
	{
		return $this->author;
	}

	/**
	 * Retrieve text of message Entity
	 *
	 * @return null|string
	 */
	public function getText(): ?string
	{
		return $this->text;
	}

	/**
	 * Retrieve text of message Entity
	 *
	 * @return string
	 */
	public function getPostedAt(): ?string
	{
		return $this->postedAt;
	}

	/**
	 * Set id of message Entity
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
	 * Set author of message Entity
	 *
	 * @param string $author
	 *
	 * @return self
	 */
	public function setAuthor(string $author): self
	{
		$this->author = $author;

		return $this;
	}

	/**
	 * Set text of message Entity
	 *
	 * @param string $text
	 *
	 * @return self
	 */
	public function setText(string $text): self
	{
		$this->text = $text;

		return $this;
	}

	/**
	 * Set postedAt of message Entity
	 *
	 * @param string $postedAt
	 *
	 * @return self
	 */
	public function setPostedAt(string $postedAt): self
	{
		$this->postedAt = $postedAt;

		return $this;
	}

	/**
	 * Transform object to array for json output
	 * 
	 * @return array
	 */
	public function toArray(): array
	{
		return [
			'id' => $this->getId(),
			'author' => $this->getAuthor(),
			'text' => $this->getText(),
			'postedAt' => $this->getPostedAt(),
		];
	}
}
