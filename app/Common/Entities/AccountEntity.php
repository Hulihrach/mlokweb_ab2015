<?php

namespace App\Common\Entities;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\IdentifiedEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="account")
 */
class AccountEntity extends IdentifiedEntity
{

	/**
	 * @ORM\Column(type="string")
	 */
	private $username;

	/**
	 * @ORM\Column(type="string")
	 */
	private $password;

	/**
	 * @ORM\Column(type="string")
	 *
	 */
	private $role;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $registered;

	/**
	 * @ORM\Column(type="string")
	 */
	private $realName;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $showRealName;

	/**
	 * @ORM\Column(type="string")
	 *
	 */
	private $regnum;

	public function getUsername()
	{
		return $this->username;
	}

	public function setUsername($username)
	{
		$this->username = $username;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function getRegnum()
	{
		return $this->regnum;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function getRegistered()
	{
		return $this->registered;
	}

	public function setRegistered($registered)
	{
		$this->registered = $registered;
	}

	public function getRole()
	{
		return $this->role;
	}

	public function setRole($role)
	{
		$this->role = $role;
	}

	public function setRegnum($num)
	{
		$this->regnum = $num;
	}

	public function getRealName()
	{
		return $this->realName;
	}

	public function setRealName($realName)
	{
		$this->realName = $realName;
	}

	public function getShowRealName()
	{
		return $this->showRealName;
	}

	public function setShowRealName($showRealName)
	{
		$this->showRealName = $showRealName;
	}

}
