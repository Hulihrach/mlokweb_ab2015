<?php

namespace App\Common\Models;

use Nette\Object;
use Kdyby\Doctrine\EntityDao;
use App\Common\Entities\PageTranslationEntity;

class PageTranslation extends Object
{

	public $pageTranslationDao;

	public function __construct(EntityDao $pageDao)
	{
		$this->pageTranslationDao = $pageDao;
	}

	/**
	 * @param array $param
	 * @return PageTranslationEntity
	 */
	public function getOneBy(array $param)
	{
		return $this->pageTranslationDao->findOneBy($param);
	}

	/**
	 * @param String $locale
	 * @return PageTranslationEntity[]
	 */
	public function getList($locale = 'cs', $display = 1)
	{
		return $this->pageTranslationDao->createQueryBuilder('pt')
			->select('pt, p')
			->leftJoin('pt.page', 'p')
			->where('pt.lang = \'' . $locale . '\'')
			->andWhere('p.display = \'' . $display . '\'')
			->getQuery()
			->execute();
	}

	public function save(PageTranslationEntity $pageTranslationEntity)
	{
		$em = $this->pageTranslationDao->getEntityManager();
		$em->persist($pageTranslationEntity);
		$em->flush();
	}

}
