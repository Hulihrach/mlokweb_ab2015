<?php

namespace App\Common\Models;

use Nette\Object;
use Kdyby\Doctrine\EntityDao;
use App\Common\Entities\LanguageEntity;

class Language extends Object
{

	protected $languageDao;

	/**
	 * @param EntityDao $languageDao
	 */
	public function __construct(EntityDao $languageDao)
	{
		$this->languageDao = $languageDao;
	}

	/**
	 * @param int $id
	 * @return LanguageEntity
	 */
	public function findLanguageByShort($id)
	{
		return $this->languageDao->findOneBy(array("short" => $id));
	}

	/**
	 * @param int $id
	 * @return LanguageEntity
	 */
	public function findLanguageById($id)
	{
		return $this->languageDao->findOneBy(array("id" => $id));
	}

	/**
	 * @return LanguageEntity[]
	 */
	public function findAll()
	{
		return $this->languageDao->findAll();
	}

	/**
	 * @param LanguageEntity $languageEntity
	 */
	public function save(LanguageEntity $languageEntity)
	{
		$em = $this->languageDao->getEntityManager();
		$em->persist($languageEntity);
		$em->flush();
	}

}
