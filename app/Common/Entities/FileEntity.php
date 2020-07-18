<?php

namespace App\Common\Entities;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\IdentifiedEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="file")
 */
class FileEntity extends IdentifiedEntity
{

	/**
	 * @ORM\Column(type="string")
	 */
	private $internalName;

	/**
	 * @ORM\Column(type="string")
	 */
	private $publicName;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $uploaded;

	public function getInternalName()
	{
		return $this->internalName;
	}

	public function getPublicName()
	{
		return $this->publicName;
	}

	public function getUploaded()
	{
		return $this->uploaded;
	}

	public function setInternalName($internalName)
	{
		$this->internalName = $internalName;
	}

	public function setPublicName($publicName)
	{
		$this->publicName = $publicName;
	}

	public function setUploaded($uploaded)
	{
		$this->uploaded = $uploaded;
	}

}
