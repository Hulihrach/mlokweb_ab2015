<?php

namespace App\Common\Entities;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\IdentifiedEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="page_translation")
 */
class PageTranslationEntity extends IdentifiedEntity
{

	/**
	 * @ORM\ManyToOne(targetEntity="PageEntity")
	 */
	private $page;

	/**
	 * @ORM\Column(type="string")
	 */
	private $title;

	/**
	 * @ORM\Column(type="string")
	 */
	private $content;

	/**
	 * @ORM\Column(type="string")
	 */
	private $lang;

	/**
	 * @ORM\Column(type="string", name="edited_last")
	 */
	private $edited;

	/**
	 * @ORM\ManyToOne(targetEntity="AccountEntity")
	 */
	private $account;

	public function getPage()
	{
		return $this->page;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function getLang()
	{
		return $this->lang;
	}

	public function getEdited()
	{
		return $this->edited;
	}

	public function getAccount()
	{
		return $this->account;
	}

	public function setPage($page)
	{
		$this->page = $page;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function setLang($lang)
	{
		$this->lang = $lang;
	}

	public function setEdited($edited)
	{
		$this->edited = $edited;
	}

	public function setAccount($account)
	{
		$this->account = $account;
	}

}
