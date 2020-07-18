<?php

namespace App\AdminModule;

use DateTime;
use Nette\Application\UI\Form;
use App\Common\Entities\ArticleEntity;
use App\Common\Entities\FileEntity;

class ArticlePresenter extends BasePresenter
{

	public function renderEdit($id)
	{
		if (!$id) {
			$this->flashMessage("Nespecifikováno ID aktuality", "danger");
			$this->redirect(":Admin:Article:list");
		} elseif (!$this->article->findBy(["contentId" => $id])) {
			$this->flashMessage("Taková aktualita neexistuje", "danger");
			$this->redirect(":Admin:Article:list");
		}

		$languages = $this->language->findAll();
		$this->template->languages = $languages;
		$this->template->articles = [];
		foreach ($languages as $lang) {
			$key = $lang->getShort();
			$this->template->articles[$key] = $this->article->findOneBy(["contentId" => $id, "lang" => $key]);
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
			$this->template->articles = $this->article->findBy(array("lang" => $filter, "display" => $display));
		} else {
			$this->template->articles = $this->article->findBy(array("display" => $display));
		}
	}

	public function renderAdd()
	{
		$this->template->languages = $this->language->findAll();
		$this->template->contentId = $this->article->getContentAutoIncrement();
	}

	/**
	 * @return Form
	 */
	public function createBaseArticleForm()
	{
		$languages = $this->language->findAll();
		$form = new Form();
		$form->addText('abbr', "Zkratka (v URL)")
			->setAttribute('placeholder', "Zkratka (v URL)");
		$form->addHidden('content_id');
		foreach ($languages as $lang) {
			$form->addText('title_' . $lang->getShort(), $this->trans('article.title'))
				->setAttribute('placeholder', 'Nadpis');
			$form->addTextArea('content_' . $lang->getShort(), $this->trans('article.content'))
				->setAttribute('placeholder', "Obsah aktuality");
		}
		$form->addSelect('display', 'Zobrazovat', [1 => "Ano", 0 => "Ne"]);
		$form->addUpload("file", "Soubor");

		return $form;
	}

	public function createComponentAddArticle()
	{
		$form = $this->createBaseArticleForm();
		$form->addSubmit('add', $this->trans('article.add'));

		$form->onSuccess[] = $this->performAddArticle;

		$form->setValues([
			"content" => "Obsah aktuality",
			"content_id" => ($this->article->getContentAutoIncrement() + 1),
		]);

		return $form;
	}

	public function performAddArticle(Form $form)
	{
		$languages = $this->language->findAll();
		$now = new DateTime('NOW');
		$vals = $form->getValues();

		if (isset($vals->file)) {
			$file = $vals->file;
			if ($file->isOk()) {
				$fileEntity = new FileEntity();
				$fileEntity->setPublicName($file->getName());
				$fileEntity->setInternalName($file->getSanitizedName());
				$fileEntity->setUploaded($now);
				$this->file->save($fileEntity);
				$file->move($this->file->getAttachmentsPath() . $file->getSanitizedName());
			}
		}

		foreach ($languages as $lang) {
			$title = "title_" . $lang->getShort();
			$content = "content_" . $lang->getShort();
			$articleEntity = new ArticleEntity();
			$articleEntity->setContentId($vals->content_id);
			$articleEntity->setAbbreviation($vals->abbr);
			$articleEntity->setTitle($vals->$title);
			$articleEntity->setContent($vals->$content);
			$articleEntity->setDisplay($vals->display);
			$articleEntity->setAccount($this->account->getAccountById($this->getUser()->getId()));
			if (isset($vals->file) && $vals->file->isOk()) {
				$articleEntity->setFile($this->file->findOneBy(["uploaded" => $now, "internalName" => $vals->file->getSanitizedName()]));
			}
			$articleEntity->setCreated_at($now);
			$articleEntity->setLang($lang->getShort());
			$this->article->save($articleEntity);
		}
		$this->flashMessage("Aktualita úspěšně přidána", "success");
		$this->redirect(":Admin:Article:list");
	}

	public function createComponentEditArticle()
	{
		$form = $this->createBaseArticleForm();
		$form->addHidden('redirect');
		$form->addSubmit('edit', $this->trans('article.edit'));
		$form->addSubmit('redirectSubmit', "Uložit a zavřít")
			->onClick[] = [$this, 'performEditArticleRedirect'];

		$form->onSuccess[] = $this->performEditArticle;

		return $form;
	}

	public function performEditArticleRedirect($button)
	{
		$vals = $button->form->getValues();
		$vals->redirect = 1;
		$this->performEditArticle($vals);
	}

	public function performEditArticle($form)
	{
		$vals = $form instanceof Form ? $form->getValues() : $form;
		foreach ($this->language->findAll() as $lang) {
			$title = "title_" . $lang->getShort();
			$content = "content_" . $lang->getShort();
			$articleEntity = $this->article->findOneBy(["contentId" => $vals->content_id, "lang" => $lang->getShort()]);
			$articleEntity->setTitle($vals->$title);
			$articleEntity->setContent($vals->$content);
			$articleEntity->setDisplay($vals->display);
			$articleEntity->setAbbreviation($vals->abbr);
			$this->article->save($articleEntity);
		}

		$this->flashMessage("Aktualita úspěšně upravena", "success");
		$vals->redirect ? $this->redirect(":Admin:Article:list") : $this->redirect("this");
	}

	public function actionDelete($id)
	{
		if (!$id) {
			$this->flashMessage("Nespecifikováno ID aktuality", "danger");
			$this->redirect(":Admin:Article:list");
		}

		$ae = $this->article->findArticleById($id);
		$ae->setDisplay(0);

		$this->article->save($ae);
		$this->flashMessage("Aktualita úspěšně smazána", "danger");
		$this->redirect(":Admin:Article:list");
	}

}
