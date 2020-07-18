<?php

namespace App\AdminModule;

use Nette\Application\UI\Form;
use App\Common\Entities\PageEntity;
use App\Common\Entities\PageTranslationEntity;

class PagePresenter extends BasePresenter
{

	public function renderAdd($id)
	{
		$this->template->languages = $this->language->findAll();
	}

	public function renderEdit($id)
	{
		if (!$id || !$this->page->getPageById($id)) {
			$this->flashMessage("Taková stránka neexistuje", "danger");
			$this->redirect(":Admin:Page:list");
		}

		$languages = $this->language->findAll();
		$this->template->languages = $languages;
		$page = $this->page->getPageById($id);
		$this->template->page = $page;
		$this->template->pageTranslations = [];
		foreach ($languages as $lang) {
			$key = $lang->getShort();
			$this->template->pageTranslations[$key] = $this->pageTranslation->getOneBy(["page" => $page, "lang" => $key]);
		}
	}

	public function renderList()
	{
		$this->template->languages = $this->language->findAll();
		$this->template->locale = $this->locale;
		$parameters = $this->request->getParameters();

		$shortLanguages = [];
		foreach ($this->language->findAll() as $lang) {
			$shortLanguages[] = $lang->getShort();
		}

		$filter = isset($parameters['filter']) ? $parameters['filter'] : $this->locale;
		if (isset($parameters['removed'])) {
			$display = 0;
		} else {
			$display = 1;
		}

		$this->template->filter = $filter;

		if (in_array($filter, $shortLanguages)) {
			$this->template->pages = $this->pageTranslation->getList($filter, $display);
		} else {
			$this->template->pages = $this->pageTranslation->getList($this->locale, $display);
		}
	}

	/**
	 * @return Form
	 */
	private function createBasePageForm()
	{
		$languages = $this->language->findAll();
		$form = new Form();
		$form->addText('abbr', 'Zkratka v URL')
			->setAttribute('placeholder', 'Může nahradit ID v adrese');
		foreach ($languages as $lang) {
			$form->addText('title_' . $lang->getShort(), 'Titulek')
				->setAttribute('placeholder', 'Je třeba zadat minimálně v 1 jazyce');
			$form->addTextArea('content_' . $lang->getShort(), 'Obsah');
		}
		$form->addSelect('display', 'Zobrazovat', [1 => "Ano", 0 => "Ne"]);

		return $form;
	}

	/**
	 * @return Form
	 */
	public function createComponentAddPage()
	{
		$form = $this->createBasePageForm();
		$form->addSubmit('add', 'Vytvořit stránku');

		$form->onSuccess[] = $this->performAddPage;

		return $form;
	}

	/**
	 * @return Form
	 */
	public function createComponentEditPage()
	{
		$form = $this->createBasePageForm();

		$form->addHidden('pageId');
		$form->addHidden('redirect');
		$form->addSubmit('edit', 'Editovat stránku');
		$form->addSubmit('redirectSubmit', "Uložit a zavřít")
			->onClick[] = [$this, 'performEditPageRedirect'];

		$form->onSuccess[] = $this->performEditPage;

		return $form;
	}

	/**
	 * @param Form $form
	 */
	public function performAddPage(Form $form)
	{
		$languages = $this->language->findAll();
		$vals = $form->getValues();
		$pageEntity = new PageEntity();
		$pageEntity->setAbbreviation($vals->abbr);
		$pageEntity->setAccount($this->account->getAccountById($this->getUser()->getId()));
		$pageEntity->setDisplay($vals->display);
		$this->page->save($pageEntity);

		foreach ($languages as $lang) {
			$title = "title_" . $lang->getShort();
			$content = "content_" . $lang->getShort();
			$pageTranslationEntity = new PageTranslationEntity();
			$pageTranslationEntity->setPage($pageEntity);
			$pageTranslationEntity->setAccount($this->account->getAccountById($this->getUser()->getId()));
			$pageTranslationEntity->setContent($vals->$content);
			$pageTranslationEntity->setTitle($vals->$title);
			$pageTranslationEntity->setLang($lang->getShort());
			$this->pageTranslation->save($pageTranslationEntity);
		}
		$this->checkPageAbbreviation();
		$this->flashMessage("Stránka úspěšně přidána", "success");
		$this->redirect(":Admin:Home:default");
	}

	public function performEditPageRedirect($button)
	{
		$vals = $button->form->getValues();
		$vals->redirect = 1;
		$this->performEditPage($vals);
	}

	public function performEditPage($form)
	{
		$vals = $form instanceof Form ? $form->getValues() : $form;
		$pageEntity = $this->page->getPageById($vals->pageId);
		$pageEntity->setAbbreviation($vals->abbr);
		$pageEntity->setDisplay($vals->display);
		$this->page->save($pageEntity);

		foreach ($this->language->findAll() as $lang) {
			$title = "title_" . $lang->getShort();
			$content = "content_" . $lang->getShort();
			$pageTranslationEntity = $this->pageTranslation->getOneBy(["page" => $this->page->getPageById($vals->pageId), "lang" => $lang->getShort()]);
			$pageTranslationEntity->setTitle($vals->$title);
			$pageTranslationEntity->setContent($vals->$content);
			$pageTranslationEntity->setAccount($this->account->getAccountById($this->getUser()->getId()));
			$this->pageTranslation->save($pageTranslationEntity);
		}
		$this->checkPageAbbreviation();
		$this->flashMessage("Stránka úspěšně editována", "success");
		$vals->redirect ? $this->redirect(":Admin:Page:list") : $this->redirect("this");
	}

	private function checkPageAbbreviation()
	{
		$pages = $this->page->getAll();
		foreach ($pages as $page) {
			if (!$page->getAbbreviation()) {
				$pageEntity = $this->page->getPageById($page->getId());
				$pageEntity->setAbbreviation($page->getId());
				$this->page->save($pageEntity);
			}
		}
	}

	public function actionDelete($id)
	{
		if (!$id) {
			$this->flashMessage("Nespecifikováno ID", "danger");
			$this->redirect(":Admin:Page:list");
		}

		$pageEntity = $this->page->getPageById($id);
		$pageEntity->setDisplay(0);
		$this->page->save($pageEntity);

		$this->flashMessage("Stránka odstraněna");
		$this->redirect(":Admin:Page:list");
	}
}
