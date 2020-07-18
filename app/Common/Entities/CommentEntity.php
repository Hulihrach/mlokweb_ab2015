<?php

namespace App\Common\Entities;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\IdentifiedEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="comment")
 */
class CommentEntity extends IdentifiedEntity
{

	/**
	 * @var ArticleEntity
	 * @ORM\ManyToOne(targetEntity="App\Common\Entities\ArticleEntity")
	 */
	private $article;

	/**
	 * @var AccountEntity
	 * @ORM\ManyToOne(targetEntity="App\Common\Entities\AccountEntity")
	 */
	private $account;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $author;

	/**
	 * @var string
	 * @ORM\Column(type="text")
	 */
	private $content;

	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	private $created_at;

	/**
	 * @var integer
	 * @ORM\Column(type="integer")
	 */
	private $display;

	public function getArticle()
	{
		return $this->article;
	}

	public function getAccount()
	{
		return $this->account;
	}

	public function setAccount(AccountEntity $account)
	{
		$this->account = $account;
	}

	public function setArticle(ArticleEntity $article)
	{
		$this->article = $article;
	}

	public function getAuthor()
	{
		return $this->author;
	}

	public function setAuthor($author)
	{
		$this->author = $author;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getCreated_at()
	{
		return $this->created_at;
	}

	public function setCreated_at(\DateTime $created_at)
	{
		$this->created_at = $created_at;
	}

	public function getDisplay()
	{
		return $this->display;
	}

	public function setDisplay($display)
	{
		$this->display = $display;
	}

}
