<?php

namespace App\FrontModule;

class PagePresenter extends BasePresenter
{

	public function renderDefault($id)
	{
		if ($this->page->getPageByAbbreviation($id)) {
			$page = $this->page->getPageByAbbreviation($id);
		} elseif ($this->page->getPageById($id)) {
			$page = $this->page->getPageById($id);
		} else {
			$this->flashMessage("Taková stránka neexistuje", "danger");
			$this->redirect(":Front:Home:default");
		}

		$this->template->page = $page;
		$this->template->content = $this->pageTranslation->getOneBy(["page" => $page->getId(), "lang" => $this->locale]);
	}

}
