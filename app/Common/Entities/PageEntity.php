<?php

namespace App\Common\Entities;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\IdentifiedEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="page")
 */
class PageEntity extends IdentifiedEntity
{

	/**
	 * @ORM\Column(type="string")
	 */
	private $abbreviation;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Common\Entities\AccountEntity")
	 */
	private $account;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $display;

	public function getAbbreviation()
	{
		return $this->abbreviation;
	}

	public function getAccount()
	{
		return $this->account;
	}

	public function getDisplay()
	{
		return $this->display;
	}

	public function setAbbreviation($abbreviation)
	{
		$this->abbreviation = $abbreviation;
	}

	public function setAccount($account)
	{
		$this->account = $account;
	}

	public function setDisplay($display)
	{
		$this->display = $display;
	}

}
