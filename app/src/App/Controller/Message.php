<?php
declare(strict_types=1);

namespace Foo\App\Controller;

use Foo\App\Model\MessageModel as MessageModel;
use Foo\Core\Request as Request;

class Message extends Controller
{
	/**
	 * Create new message
	 *
	 * @param Request $request
	 */
	public function postNew(Request $request): void
	{
		$message = (new MessageModel())->createMessage(
			$this->user,
			$request->getPostData()
		);

		echo json_encode($message->toArray());die;
	}

	/**
	 * Get all messages for periodic refresh
	 */
	public function getMessages(): void
	{
    	$messages = (new MessageModel())->getBroadcastMessages(true);

    	echo json_encode($messages);die;
	}
}
