<?php

namespace App\Common\Models;

use Nette\Object;
use Kdyby\Doctrine\EntityDao;
use App\Common\Entities\FileEntity;

class File extends Object
{

	/**
	 * @var type EntityDao
	 */
	protected $fileDao;

	protected $path;

	public function __construct(EntityDao $entityDao, $path)
	{
		$this->fileDao = $entityDao;
		$this->path = $path;
	}

	public function save(FileEntity $fileEntity)
	{
		$em = $this->fileDao->getEntityManager();
		$em->persist($fileEntity);
		$em->flush();
	}

	/**
	 * @param array $criteria
	 * @return FileEntity
	 */
	public function findOneBy(array $criteria)
	{
		return $this->fileDao->findOneBy($criteria);
	}

	public function getAttachmentsPath()
	{
		return $this->path;
	}

}
