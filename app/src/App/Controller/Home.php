<?php
declare(strict_types=1);

namespace Foo\App\Controller;

use Foo\Core\Request as Request;
use Foo\Core\View as View;
use Foo\App\Model\UserModel as UserModel;
use Foo\App\Model\MessageModel as MessageModel;

class Home extends Controller {
	/**
	 * Render home view
	 */
    public function getIndex(): void
    {
    	$connectedUsers = (new UserModel())->getConnectedUsers();
    	$messages = (new MessageModel())->getBroadcastMessages();
    	$view = new View('home');
    	$view->assign('users', $connectedUsers);
    	$view->assign('messages', $messages);
    }
}
