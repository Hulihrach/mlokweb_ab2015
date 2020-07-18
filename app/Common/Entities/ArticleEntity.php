<?php

namespace App\Common\Entities;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\IdentifiedEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="article")
 */
class ArticleEntity extends IdentifiedEntity
{

	/**
	 * @ORM\Column(type="integer")
	 */
	private $contentId;

	/**
	 * @ORM\Column(type="string")
	 */
	private $abbreviation;

	/**
	 * @ORM\Column(type="string")
	 */
	private $title;

	/**
	 * @ORM\Column(type="string")
	 */
	private $content;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Common\Entities\AccountEntity")
	 */
	private $account;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Common\Entities\FileEntity")
	 */
	private $file;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $created_at;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $display;

	/**
	 * @ORM\Column(type="string")
	 */
	private $lang;

	function getContentId()
	{
		return $this->contentId;
	}

	function setContentId($contentId)
	{
		$this->contentId = $contentId;
	}

	public function getAbbreviation()
	{
		return $this->abbreviation;
	}

	public function setAbbreviation($abbreviation)
	{
		$this->abbreviation = $abbreviation;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getAccount()
	{
		return $this->account;
	}

	public function setAccount($account)
	{
		$this->account = $account;
	}

	public function getFile()
	{
		return $this->file;
	}

	public function setFile(FileEntity $file)
	{
		$this->file = $file;
	}

	public function getCreated_at()
	{
		return $this->created_at;
	}

	public function setCreated_at($created_at)
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

	public function getLang()
	{
		return $this->lang;
	}

	public function setLang($lang)
	{
		$this->lang = $lang;
	}

}
