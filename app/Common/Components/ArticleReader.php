<?php

namespace App\Common\Components;

use Nette\Application\UI;

class ArticleReader extends UI\Control
{

	protected $article;

	public function __construct($article)
	{
		parent::__construct();
		$this->article = $article;
	}

	public function render($id)
	{
		$template = $this->template;
		$template->setFile(__DIR__ . '/ArticleReader.latte');
		$template->id = $id;
		$template->render();
	}

	public function getStart()
	{
		return $this->article->findAll();
	}

}
