<?php

namespace App\Common\Entities;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\IdentifiedEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="language")
 */
class LanguageEntity extends IdentifiedEntity
{

	/**
	 * @ORM\Column(type="string")
	 */
	private $short;

	/**
	 * @ORM\Column(type="string")
	 */
	private $name;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $active;

	public function getName()
	{
		return $this->name;
	}

	public function getShort()
	{
		return $this->short;
	}

	public function getActive()
	{
		return $this->active;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setShort($short)
	{
		$this->short = $short;
	}

	public function setActive($active)
	{
		$this->active = $active;
	}

}
