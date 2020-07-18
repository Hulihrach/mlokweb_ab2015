<?php

namespace App\Common\Models;

use Nette\Object;
use Kdyby\Doctrine\EntityDao;
use App\Common\Entities\CommentEntity;
use Nette\ArrayHash;

class Comment extends Object
{

	public $commentDao;

	public function __construct(EntityDao $commentDao)
	{
		$this->commentDao = $commentDao;
	}

	/**
	 * @param integer $id
	 * @return CommentEntity
	 */
	public function findCommentById($id)
	{
		return $this->commentDao->findOneBy(['id' => $id]);
	}

	/**
	 * @param CommentEntity $commentEntity
	 */
	public function save(CommentEntity $commentEntity)
	{
		$em = $this->commentDao->getEntityManager();
		$em->persist($commentEntity);
		$em->flush();
	}

	/**
	 * @param integer $article_id
	 */
	public function findCommentsByArticle($article)
	{
		return ArrayHash::from($this->commentDao->findBy(["article" => $article], ["created_at" => "desc"]));
	}

	/**
	 * @param array $criteria
	 * @param array $orderBy
	 * @param integer $limit
	 * @param integer $offset
	 * @return CommentEntity[]
	 */
	public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
	{
		return $this->commentDao->findBy($criteria, $orderBy, $limit, $offset);
	}

}
