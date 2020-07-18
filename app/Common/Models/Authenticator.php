<?php

namespace App\Common\Models;

use Nette\Object;
use Nette\Security\IAuthenticator;
use Nette\Security as NS;

class Authenticator extends Object implements IAuthenticator
{

	/**
	 * @var Account
	 */
	protected $account;

	function __construct(Account $account)
	{
		$this->account = $account;
	}

	function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;
		$row = $this->account->findOneBy(array("username" => $username));

		if (!$row) {
			throw new NS\AuthenticationException('messages.forms.login.user_not_found');
		}

		if (!password_verify($password, $row->getPassword())) {
			throw new NS\AuthenticationException('messages.forms.login.invalid_password');
		}

		$roles = explode(",", $row->getRole());
		$account = $this->account->findOneBy(["username" => $username]);
		$data = [
			"username" => $account->getUsername(),
			"role" => $account->getRole(),
			"registered" => $account->getRegistered(),
			"realName" => $account->getRealName(),
			"showRealName" => $account->getShowRealName(),
			"regnum" => $account->getRegnum(),
		];
		return new NS\Identity($row->getId(), $roles, $data);
	}

}
