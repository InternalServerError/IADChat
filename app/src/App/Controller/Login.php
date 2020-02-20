<?php
declare(strict_types=1);

namespace Foo\App\Controller;

use Foo\App\Entity\UserEntity as AppUser;
use Foo\App\Model\UserModel as UserModel;
use Foo\Core\Request as Request;
use Foo\Core\Router as Router;
use Foo\Core\View as View;

class Login extends Controller
{
	/**
	 * Render login form view
	 */
	public function getIndex(): void
	{
    	$view = new View('login');
    	$view->assign('error', $_SESSION['loginError']);
	}

	/**
	 * Get the user if credentials are valid
	 * Create new User if nickname does not already exists
	 * Redirect to login page if duplicate nickname found
	 *
	 * @param Request $request
	 * 
	 * @return AppUser
	 */
	public function postSignin(Request $request): AppUser
	{
		try {
			unset($_SESSION['loginError']);

			$user = (new UserModel())->getUser($request->getPostData());
			$_SESSION['loggedIn'] = true;
			$_SESSION['LoggedUser'] = serialize($user);


			Router::redirectTo();
		} catch (\Throwable $t) {
			$_SESSION['loginError'] = $t->getMessage();

			Router::redirectTo('/login');
		}
	}

	/**
	 * Logout user and redirect to login page
	 */
	public function getLogout(): void
	{
		(new UserModel())->clearSessions($this->user);
		unset($_SESSION['loggedIn']);
		unset($_SESSION['LoggedUser']);
		$this->user = null;

		Router::redirectTo('/login');
	}
}
