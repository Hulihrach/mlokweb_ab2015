<?php

namespace App\AdminModule;

use Nette\Application\UI\Form;
use App\Common\Entities\LanguageEntity;

class LanguagePresenter extends BasePresenter
{

	public function renderList()
	{
		$this->template->languages = $this->language->findAll();
	}

	public function actionDelete($id)
	{
		if (!$id) {
			$this->flashMessage("Nezadáno ID");
			$this->redirect(":Admin:Language:list");
		}

		$languageEntity = $this->language->findLanguageById($id);
		$languageEntity->setActive(0);

		$this->language->save($languageEntity);

		$this->flashMessage("Jazyk \"{$languageEntity->getName()}\" již nebude zobrazován");
		$this->redirect(":Admin:Language:list");
	}

	/**
	 * @return Form
	 */
	protected function createComponentAddLanguage()
	{
		$form = new Form();
		$form->addText("name", "Název")
			->setAttribute("placeholder", "English")
			->setRequired("Zadejte název");
		$form->addText("short", "Zkratka")
			->setAttribute("placeholder", "en")
			->setRequired("Zadejte zkratku");
		$form->addSubmit("add", "Přidat");

		$form->onSuccess[] = $this->performAddLanguage;

		return $form;
	}

	public function performAddLanguage($form)
	{
		$values = $form->getValues();

		$languageEntity = new LanguageEntity();
		$languageEntity->setShort($values->short);
		$languageEntity->setName($values->name);
		$languageEntity->setActive(1);

		$this->language->save($languageEntity);

		$this->flashMessage("Jazyk přidán");
		$this->redirect(":Admin:Language:list");
	}

}
