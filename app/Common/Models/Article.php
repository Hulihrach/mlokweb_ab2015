<?php

namespace App\Common\Models;

use Nette\Object;
use Kdyby\Doctrine\EntityDao;
use App\Common\Entities\ArticleEntity;

class Article extends Object
{

	/** @var EntityDao */
	private $articleDao;

	public function __construct(EntityDao $articleDao)
	{
		$this->articleDao = $articleDao;
	}

	/**
	 * @param integer $id
	 * @return ArticleEntity
	 */
	public function findArticleById($id)
	{
		return $this->articleDao->findOneBy(['id' => $id]);
	}

	/**
	 * @param integer $id
	 * @return ArticleEntity
	 */
	public function findArticleByContentId($id)
	{
		return $this->articleDao->findOneBy(["contentId" => $id], ["id" => "asc"]);
	}

	/**
	 * @param ArticleEntity $articleEntity
	 */
	public function save(ArticleEntity $articleEntity)
	{
		$em = $this->articleDao->getEntityManager();
		$em->persist($articleEntity);
		$em->flush();
	}

	/**
	 * @param integer $limit
	 * @return ArticleEntity[]
	 */
	public function findNum($limit = null)
	{
		return $this->articleDao->createQueryBuilder("a")
			->setMaxResults($limit)
			->getQuery()
			->execute();
	}

	/**
	 * @param array $criteria
	 * @return ArticleEntity
	 */
	public function findOneBy(array $criteria)
	{
		return $this->articleDao->findOneBy($criteria);
	}

	/**
	 * @param array $criteria
	 * @return ArticleEntity[]
	 */
	public function findBy(array $criteria, $orderBy = null, $limit = null)
	{
		return $this->articleDao->findBy($criteria, $orderBy, $limit);
	}

	/**
	 * @return ArticleEntity[]
	 */
	public function findAll()
	{
		return $this->articleDao->findAll();
	}

	/**
	 * @return string
	 */
	public function articlesCount()
	{
		return $this->articleDao->createQueryBuilder("a")
			->select("COUNT(a.id)")
			->getQuery()
			->getSingleScalarResult();
	}

	public function getContentAutoIncrement()
	{
		$articles = $this->findBy([], ["contentId" => "DESC"]);
		return isset($articles[0]) ? $articles[0]->getContentId() : 1;
	}

	/**
	 * @return ArticleEntity[]
	 */
	public function getArticleList($offset, $locale, $limit)
	{
		return $this->articleDao->createQueryBuilder("a")
			->select("a")
			->where("a.lang = :locale")
			->andWhere("a.display = 1")
			->andWhere("a.content != ''")
			->groupBy("a.contentId")
			->orderBy("a.created_at", "DESC")
			->setParameter("locale", $locale)
			->setFirstResult($offset)
			->setMaxResults($limit)
			->getQuery()
			->getResult();
	}

}
