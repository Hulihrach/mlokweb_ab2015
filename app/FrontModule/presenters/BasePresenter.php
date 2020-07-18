<?php

namespace App\FrontModule;

use App\Presenters\GlobalPresenter;

class BasePresenter extends GlobalPresenter
{

	public function beforeRender()
	{
		$this->template->propozice = $this->page->getPageByAbbreviation("propozice");
	}

	public function startup()
	{
		parent::startup();

		$this->template->locale = $this->locale;
		$this->template->languages = $this->language->findAll();
		$this->template->pages = $this->pageTranslation->getList($this->locale);
	}

}
