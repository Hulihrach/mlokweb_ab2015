<?php

namespace App\Common\Models;

use Nette\Object;
use Kdyby\Doctrine\EntityDao;
use App\Common\Entities\PageEntity;

class Page extends Object
{

	/**
	 * @var EntityDao
	 */
	private $pageDao;

	public function __construct(EntityDao $pageDao)
	{
		$this->pageDao = $pageDao;
	}

	/**
	 * @param integer $id
	 * @return PageEntity
	 */
	public function getPageById($id)
	{
		return $this->pageDao->findOneBy(['id' => $id]);
	}

	/**
	 * @param String $abbreviation
	 * @return PageEntity
	 */
	public function getPageByAbbreviation($abbreviation)
	{
		return $this->pageDao->findOneBy(['abbreviation' => $abbreviation]);
	}

	/**
	 * @param array $param
	 * @return PageEntity
	 */
	public function getOneBy(array $param)
	{
		return $this->pageDao->findOneBy($param);
	}

	/**
	 * @return PageEntity[]
	 */
	public function getAll()
	{
		return $this->pageDao->findAll();
	}

	public function save(PageEntity $pageEntity)
	{
		$em = $this->pageDao->getEntityManager();
		$em->persist($pageEntity);
		$em->flush();
	}

}
