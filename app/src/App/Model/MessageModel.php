<?php
declare(strict_types=1);

namespace Foo\App\Model;

use Foo\App\Entity\MessageEntity as MessageEntity;
use Foo\Utils\Helper as Helper;

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
			Helper::redirectToErrorPage();
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
}
