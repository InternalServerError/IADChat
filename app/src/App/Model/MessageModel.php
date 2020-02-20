<?php
declare(strict_types=1);

namespace Foo\App\Model;

use Foo\App\Entity\MessageEntity as MessageEntity;
use Foo\App\Entity\UserEntity as UserEntity;
use Foo\Core\Router as Router;

class MessageModel extends Model
{
	/**
	 * Get messages
	 *
	 * @return array
	 */
	public function getBroadcastMessages(bool $toArray = false): array
	{
		try {
			$sqlQuery = "SELECT m.id as id, m.posted_at AS posted_at, m.text as text, u.nickname AS author "
						. "FROM messages m "
						. "INNER JOIN users u "
							. "ON m.author = u.id "
						. "WHERE m.broadcast = 1 "
						. "ORDER BY m.posted_at ASC";
			$stmt = $this->pdo->prepare($sqlQuery);
			$stmt->execute();
			$rawMessages = $stmt->fetchAll();
		} catch (\Throwable $t) {
			Router::renderErrorPage();
		}

		$messages = array_map(function($rawMessage) use ($toArray) {
			$msg = (new MessageEntity())->setId($rawMessage['id'])
						->setAuthor($rawMessage['author'])
						->setText($rawMessage['text'])
						->setPostedAt((new \DateTime($rawMessage['posted_at']))->format('d/m/Y H:i:s'));

		return $toArray === true ? $msg->toArray() : $msg;
		}, $rawMessages);

		return $messages;
	}

	/**
	 * Create new message
	 * 
	 * @param UserEntity $user
	 * @param array $data
	 *
	 * @return MessageEntity
	 */
	public function createMessage(UserEntity $user, array $data): MessageEntity
	{
		$messageId = $this->generateUuid();

		try {
			$sqlQuery = "INSERT INTO messages VALUES(:id, :text, :author, CURRENT_TIMESTAMP(), NULL, 1)";
			$stmt = $this->pdo->prepare($sqlQuery);
			$stmt->execute([
				':id' => $messageId,
				':text' => $data['text'],
				':author' => $user->getId()
			]);
		} catch (\Throwable $t) {
			Router::renderErrorPage();
		}

		$message = (new MessageEntity())->setId($messageId)
					->setAuthor($user->getNickname())
					->setText($data['text']);

		return $message;
	}
}