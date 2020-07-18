<?php

namespace App\Common\Models;

use Nette\Security\User as NU;
use Nette\Security\IUserStorage;
use Nette\Security\IAuthenticator;
use Nette\Security\IAuthorizator;

class User extends NU
{

	/*
	 * @var App\Common\Entites\AccountEntity
	 */
	private $accountEntity;

	public function __construct(IUserStorage $storage, IAuthenticator $authenticator = NULL, IAuthorizator $authorizator = NULL)
	{
		parent::__construct($storage, $authenticator, $authorizator);
	}

	public function login($id = NULL, $password = NULL)
	{
		parent::login($id, $password);
	}

	public function getAccountEntity()
	{
		return $this->accountEntity;
	}

	public function setAccountEntity($accountEntity)
	{
		$this->accountEntity = $accountEntity;
	}

}
